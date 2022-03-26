<?php
namespace Rsruman\Category\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image'
    ];

    public function child_categories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ChildCategory::class, 'category_id', 'id');
    }
}
