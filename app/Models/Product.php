<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    public const ID = 'id';
    public const NAME = 'name';
    public const PRICE = 'price';
    public const STATUS = 'status';
    public const IS_ARCHIVE = 'is_archive';

    protected $table = 'product';
    protected $hidden = ['pivot'];
    public $timestamps = false;

    protected $fillable = [
        self::NAME,
        self::PRICE
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }
}
