<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Post extends Model
{
    //
    protected $fillable = [
    'title',
    'slug',
    'category_id',
    'color',
    'image',
    'body',
    'tags',
    'published',
    ];
    protected $casts = [
    'tags' => 'array',
    'published' => 'boolean',
    'published_at' => 'date',
];
public function category()
{
 return $this->belongsTo(Category::class);
}

}
