<?php

namespace App;

use App\Category;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
    	'name', 'parent_id'
    ];

    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    public function children()
    {
    	return $this->HasMany(Category::class, 'parent_id', 'id');
    }
}
