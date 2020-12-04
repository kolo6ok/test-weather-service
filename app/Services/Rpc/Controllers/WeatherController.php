<?php


namespace App\Services\Rpc\Controllers;


use App\Models\History;
use App\Services\Rpc\Exceptions\JsonRpcException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class WeatherController
{

    /**
     * @param array $params
     * @return History|array
     * @throws JsonRpcException
     */
    public function getByDate(array $params)
    {
        $validator = Validator::make($params,[
            'date' => 'required|regex:/[0-9]{4}-[0-9]{2}-[0-9]{2}/i'
        ]);

        if ($validator->fails()) {
            throw new JsonRpcException('Invalid params', JsonRpcException::INVALID_PARAMS);
        }

        $history = History::where('date_at','=',$params['date'])->first();
        return $history ?? [];
    }

    /**
     * @param array $params
     * @return array
     * @throws JsonRpcException
     */
    public function getHistory(array $params)
    {
        $validator = Validator::make($params,[
            'lastDays' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            throw new JsonRpcException('Invalid params', JsonRpcException::INVALID_PARAMS);
        }

        $now = Carbon::now();
        $first = Carbon::now()->subDays($params['lastDays']);

        return History::whereBetween('date_at',[$first,$now])->get()->all();
    }
}
