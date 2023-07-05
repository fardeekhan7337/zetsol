<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $fillable = [

        'order_id',
        'product_id',
        'qty',
        'price',
        'amount',

    ];

    public function product()
    {
        return $this->belongsTo(Products::class,'product_id','id');
    }
}