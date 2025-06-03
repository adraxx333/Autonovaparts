<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'user_id',
        'order_number',
        'total_amount',
        'status',
        'shipping_email',
        'shipping_phone',
        'shipping_name',
        'shipping_address',
        'shipping_city',
        'shipping_postal_code'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->uuid)) {
                $order->uuid = (string) Str::uuid();
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function generateOrderNumber(): string
    {
        $prefix = 'ORD';
        $date = now()->format('Ymd');
        $random = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        return "{$prefix}-{$date}-{$random}";
    }

    public function updateStock(): void
    {
        foreach ($this->items as $item) {
            $part = Part::find($item->part_id);
            if ($part) {
                $part->stock -= $item->quantity;
                $part->save();
            }
        }
    }
}
