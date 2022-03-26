<?php

namespace Rsruman\Category\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubChildCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'child_category_id',
        'name',
        'slug',
        'image'
    ];

    public function child_category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ChildCategory::class, 'child_category_id', 'id');
    }
}
