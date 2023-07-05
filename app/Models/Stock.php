<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [

        'product_id',
        'qty',
        'type',

    ];

    public function product()
    {
        return $this->belongsTo(Products::class,'product_id','id');
    }

}