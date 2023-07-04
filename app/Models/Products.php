<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    public $timestamps = true;
    
    protected $fillable = [

        'image',
        'title',
        'price',
        'cat_id',
        'is_active',
        'description',

    ];

    public function category()
    {
        return $this->belongsTo(Category::class,'cat_id','id');
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class,'product_id','id');
    }

    public function getAvailableQtyAttribute()
    {
        
        $addQty = $this->stocks()->where('type', 'add')->sum('qty');
        $removeQty = $this->stocks()->where('type', 'remove')->sum('qty');
        
        return $addQty - $removeQty;
    }

}