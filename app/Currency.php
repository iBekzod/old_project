<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Currency
 *
 * @property int $id
 * @property string $name
 * @property string $symbol
 * @property float $exchange_rate
 * @property int $status
 * @property string|null $code
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Currency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Currency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Currency query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Currency whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Currency whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Currency whereExchangeRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Currency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Currency whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Currency whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Currency whereSymbol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Currency whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class Currency extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('status', function (Builder $builder) {
            $builder->where('status', 1);
        });
    }

    public function appSettings()
    {
        return $this->hasOne(AppSettings::class);
    }
}
