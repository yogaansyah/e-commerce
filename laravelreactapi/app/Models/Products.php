<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'meta_title',
        'meta_keyword',
        'meta_descrip',
        'slug',
        'name',
        'description',
        'brand',
        'selling_price',
        'original_price',
        'qty',
        'image',
        'featured',
        'popular',
        'status',
    ];

    protected $with = ['category'];
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
