<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
	protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
		'category',
		'status',
    ];
	
	public function scopeName($query, $name)
	{
		if ($name) {
			$query->where('name', 'like', "%$name%");
		}
	}
	
	public function scopeMinPrice($query, $price)
    {
        if ($price) {
            $query->where('price','>=',$price);
        }
    }

    public function scopeMaxPrice($query, $price)
    {
        if ($price) {
            $query->where('price','<=',$price);
        }
    }
	/**/
}
