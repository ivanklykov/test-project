<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    public const ID = 'id';
    public const NAME = 'name';

    protected $table = 'category';

    protected $hidden = ['pivot'];

    public $timestamps = false;

    protected $fillable = [
        self::NAME
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_category');
    }
}
