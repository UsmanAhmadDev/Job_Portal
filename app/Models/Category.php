<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    // In Category.php model
    public function jobs()
    {
        return $this->hasMany(Job::class, 'category_id');
    }
}
