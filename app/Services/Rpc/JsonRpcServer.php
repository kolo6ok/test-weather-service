<?php

namespace App\Services\Rpc;

use App\Services\Rpc\Controllers\WeatherController;
use App\Services\Rpc\Exceptions\JsonRpcException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use ReflectionClass;

class JsonRpcServer
{
    protected array $controllers = [
        'weather' => WeatherController::class
    ];

    public function handle(Request $request)
    {
        try {
            $content = json_decode($request->getContent(), true);

            if (empty($content)) {
                throw new JsonRpcException('Parse error', JsonRpcException::PARSE_ERROR);
            }

            $validator = Validator::make($content,[
                'jsonrpc' => 'required|regex:/2\.0/i',
                'method' => 'required',
                'id' => 'required'
            ]);

            if ($validator->fails()) {
                throw new JsonRpcException('Invalid request', JsonRpcException::INVALID_REQUEST);
            }

            $controllerName = explode('.',$content['method'])[0];
            $methodName = explode('.',$content['method'])[1];

            $result = $this->call($controllerName,$methodName,$content['params']);

            return JsonRpcResponse::success($result, $content['id']);
        } catch (JsonRpcException $e) {
            return JsonRpcResponse::error([
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ]);
        } catch (Exception $e) {
            return JsonRpcResponse::error([
                'code' => JsonRpcException::INTERNAL_ERROR,
                'c' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param string $controllerName
     * @param string $methodName
     * @param array $params
     * @return mixed
     * @throws JsonRpcException
     * @throws \ReflectionException
     */
    private function call(string $controllerName, string $methodName, array $params)
    {
        $class = $this->controllers[$controllerName];
        $reflectionClass = new ReflectionClass($class);
        if (
            !array_key_exists($controllerName,$this->controllers)
            or !in_array($methodName,array_column($reflectionClass->getMethods(),'name'))
        ) {
            throw new JsonRpcException('Method not found', JsonRpcException::METHOD_NOT_FOUND);
        }

        $controller = new $class();

        return $controller->{$methodName}($params);
    }
}
