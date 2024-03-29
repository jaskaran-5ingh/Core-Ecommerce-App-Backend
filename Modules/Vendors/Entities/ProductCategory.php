<?php

namespace Modules\Vendors\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Vendors\Database\factories\ProductCategoryFactory;

class ProductCategory extends Model
{
    use HasFactory;

    protected $hidden = ['parent_id', 'status',  'deleted_at', 'updated_at'];
    protected $table = 'product_categories';
    protected $fillable = ['title', 'parent_id', 'status', 'units', 'description'];

    protected static function newFactory()
    {
        return ProductCategoryFactory::new();
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function variants(): BelongsToMany
    {
        return $this->belongsToMany(ProductVariant::class, ProductCategoryVariant::class, 'category_id', 'variant_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }
}
