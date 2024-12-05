<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'orderdate',
        'total',
        'voucher_id',
        'current_status',
        'feeship',
        'totalmoney',
        'address_id',
        'method_payment'
    ];


    protected static function boot()
    {
        parent::boot();

        // Sự kiện trước khi tạo mới order
        static::creating(function ($order) {
            $order->order_id = self::generateRandomString();
        });
    }


    public static function generateRandomString($length = null)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charactersLength = strlen($characters);
        $length = $length ?? rand(8, 14);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    public function details()
{
    return $this->hasMany(OrderDetails::class, 'order_id', 'order_id');
}


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function trackingOrders()
    {
        return $this->hasMany(TrackingOrder::class, 'order_id', 'order_id');
    }

    public function voucher()
    {
        if ($this->voucher_id) {
            return Voucher::where('voucher_id', '=', $this->voucher_id)->first();
        }
        return null; // Hoặc trả về giá trị mặc định khác phù hợp với ứng dụng của bạn
    }

    public function review(){
        return $this->belongsTo(Reviews::class,'order_id', 'order_id');
    }
}
