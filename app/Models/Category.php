<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Định nghĩa bảng tương ứng
    protected $table = 'categories';

    // Các thuộc tính có thể gán đại trà (mass assignable)
    protected $fillable = ['name', 'description', 'status'];

    // Quan hệ với bảng product
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Quan hệ với bảng category
    public function subcategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
