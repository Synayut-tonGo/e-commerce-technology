<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    //
    use HasFactory;

    protected $table = 'Orders';
    protected $primaryKey = 'orders';
    
    protected $fillable = [
        'user_id',
        'order_type',
        'status',
        'total_amount'
    ];

    public function users () {
        return $this->belongsTo(Users::class , 'user_id', 'user_id');
    }
    public function OrderItem () {
        return $this->hasMany(OrderItem::class , 'order_id', 'order_id');
    }
    
    public function payments () {
        return $this->hasMany(Payments::class , 'order_id' , 'order_id');
    }

}
