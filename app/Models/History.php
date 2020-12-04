<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\History
 *
 * @property int $id
 * @property float $temp
 * @property string $date_at
 * @method static \Illuminate\Database\Eloquent\Builder|History newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|History newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|History query()
 * @method static \Illuminate\Database\Eloquent\Builder|History whereDateAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|History whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|History whereTemp($value)
 * @mixin \Eloquent
 */
class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'temp',
        'date_at',
    ];

    protected $hidden = [
        'id'
    ];

    protected $casts = [
        'date_at' => 'date:Y-m-d',
    ];

    public $timestamps = false;

}
