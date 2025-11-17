<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    //
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'brand_id',
        'name',
        'description',
        'price',
        'stock_quantity',
        'is_preorder_available',
        'status',
    ];

    public function brands(){
        return $this->belongsTo(Brands::class , 'brand_id' , 'brand_id');
    }

    public function cartItem () {
        return $this->hasMany(CartItem::class , 'product_id' , 'product_id');
    }
    
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id', 'product_id');
    }

    public function image () {
        return $this->hasMany(ProductImage::class , 'product_id' , 'product_id');
    }

}
