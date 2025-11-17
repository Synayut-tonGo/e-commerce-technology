<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    //
    use HasFactory;

    protected $table = 'product_image';
    protected $primaryKey = 'product_image_id';

    protected $fillable = [
        'image'
    ];

    public function products () {
        return $this->belongsTo(Products::class , 'product_id' , 'product_id');
    }
}
