<?php

namespace App\Models;

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
        'price',
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
}
