<?php

namespace VictorAvelar\Geld\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Currency
 *
 * @package VictorAvelar\Geld\Models
 * @author Victor Avelar <deltatuts@gmail.com>
 */
class Currency extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'rate',
        'imported_at',
    ];
}
