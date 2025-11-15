<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brands extends Model
{
    //
    use HasFactory;

    protected $table = 'Brands';
    protected $primaryKey = 'brand_id';
    protected $fillable = [
        'name',
        'description',
        'image',
    ];
    public function product(){
        return $this->hasMany(Products::class , 'brand_id' , 'brand_id');
    }
}
