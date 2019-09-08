<?php

namespace VictorAvelar\Geld\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CurrencyHistory
 *
 * @package VictorAvelar\Geld\Models
 * @author Victor Avelar <deltatuts@gmail.com>
 */
class CurrencyHistory extends Model
{
    use SoftDeletes;

    protected $table = 'currency_history';

    protected $fillable = [
        'code',
        'rate',
        'imported_at',
        'valid_until',
    ];
}
