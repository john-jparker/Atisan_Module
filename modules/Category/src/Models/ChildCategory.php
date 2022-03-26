<?php

namespace Rsruman\Category\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'image'
    ];

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function sub_child_categories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SubChildCategory::class,  'child_category_id', id);
    }
}
