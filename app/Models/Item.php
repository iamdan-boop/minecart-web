<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Item
 *
 * @property-read \App\Models\User $owner
 * @method static \Database\Factories\ItemFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Item newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Item newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Item query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $buyer_name
 * @property int $type
 * @property float $price
 * @property string $note
 * @property int $status
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $drop_date
 * @property \Illuminate\Support\Carbon|null $claimed_date
 * @property string $display_price
 * @property string $shelf_location
 * @property float $handling_fee
 * @property \Illuminate\Support\Carbon $expiry_date
 * @property string $display
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereBuyerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereClaimedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereDisplayPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereDropDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereExpiryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereHandlingFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereShelfLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereUserId($value)
 */
class Item extends Model
{
    use HasFactory;

    public static int $ITEM_STATUS_PENDING = 0;
    public static int $ITEM_STATUS_CLAIMING = 1;
    public static int $ITEM_STATUS_CLAIMED = 2;
    public static int $ITEM_STATUS_PULLOUT = 3;

    public static int $ITEM_TYPE_FOOD = 0;
    public static int $ITEM_TYPE_OTHERS = 1;

    protected $fillable = [
        'buyer_name',
        'price',
        'type',
        'note',
        'status',
        'user_id',
        'drop_date',
        'claimed_date',
        'display_price',
        'shelf_location',
        'handling_fee',
        'expiry_date',
        'display'
    ];


    protected $dates = [
        'drop_date',
        'claimed_date',
        'expiry_date'
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
                    self::$ITEM_STATUS_PENDING => 'For Approval',
                    self::$ITEM_STATUS_CLAIMED => 'Claimed',
                    self::$ITEM_STATUS_CLAIMING => 'For Claiming',
                    self::$ITEM_STATUS_PULLOUT => 'Pullout'
                };
            }
        );
    }
}
