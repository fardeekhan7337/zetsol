<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $fillable = [

        'order_no',
        'full_name',
        'email',
        'contact_no',
        'total_price',
        'address',
        'status',

    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class,'order_id','id');
    }
    
}