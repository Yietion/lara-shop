<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
	const TYPE_NORMAL = 'normal';
	const TYPE_CROWDFUNDING = 'crowdfunding';
	
	public static $typemap = [
			self::TYPE_NORMAL  => '普通商品',
			self::TYPE_CROWDFUNDING => '众筹商品',
	];
	
    //
    protected $fillable = [
        'title', 'description', 'image', 'on_sale',
        'rating', 'sold_count', 'review_count', 'price', 'type'
    ];
    
    protected $caste = [
        'on_sale' => 'boolean',
    ];
    
    public function skus()
    {
        return $this->hasMany(ProductSku::class);
    }
    
    public function getImageUrlAttribute()
    {
        if(Str::startsWith($this->attributes['image'], ['http://', 'https://'])){
            return $this->attributes['image'];
        }
        return \Storage::disk('public')->url($this->attributes['image']);
    }
    
    public function category()
    {
    	return $this->belongsTo(Category::class);
    }
    
    public function crowdfunding()
    {
    	return $this->hasOne(CrowdfundingProduct::class);
    }
}
