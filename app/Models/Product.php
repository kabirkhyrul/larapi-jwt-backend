<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'price',
        'image'
    ];

    /**
     * Get the images path.
     *
     * @param string $value
     * @return string
     */
    public function getImageAttribute(string $value): string
    {
        return asset(Storage::url($value));
    }
}
