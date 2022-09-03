<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 * @property-read \App\Models\User|null $owner
 */
class Cashout extends Model
{
    use HasFactory;

    public static int $CASHOUT_STATUS_PENDING = 0;
    public static int $CASHOUT_STATUS_FOR_CLAIMING = 1;
    public static int $CASHOUT_STATUS_CLAIMED = 2;


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


    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    public function status(): Attribute
    {
        return Attribute::make(
            get: function (int $value) {
                return match ($value) {
                    self::$CASHOUT_STATUS_PENDING => 'PENDING',
                    self::$CASHOUT_STATUS_FOR_CLAIMING => 'FOR CLAIMING',
                    self::$CASHOUT_STATUS_CLAIMED => 'CLAIMED'
                };
            },
        );
    }
}
