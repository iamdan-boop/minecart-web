<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Cashout
 *
 * @property int $id
 * @property string $name
 * @property float $amount
 * @property string $status
 * @property string|null $request_date
 * @property string|null $approved_date
 * @property string|null $release_date
 * @property string|null $received_date
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\CashoutFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Cashout newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cashout newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cashout query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cashout whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cashout whereApprovedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cashout whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cashout whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cashout whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cashout whereReceivedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cashout whereReleaseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cashout whereRequestDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cashout whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cashout whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cashout whereUserId($value)
 * @mixin \Eloquent
 */
class Cashout extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'amount',
        'status',
        'request_date',
        'approved_date',
        'release_date',
        'received_date',
        'user_id'
    ];



}