<?php

namespace App;

use App\Category;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
    	'name', 'parent_id', 'order'
    ];

    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    public function children()
    {
    	return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }
}
