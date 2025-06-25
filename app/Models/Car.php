<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand',
        'model',
        'year',
        'price',
        'color',
        'transmission',
        'fuel_type',
        'mileage',
        'description',
        'image',
        'gallery',
        'status',
        'featured'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'gallery' => 'array',
        'featured' => 'boolean',
        'year' => 'integer',
        'mileage' => 'integer'
    ];

    // Accessor untuk format harga
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    // Accessor untuk nama lengkap mobil
    public function getFullNameAttribute()
    {
        return $this->brand . ' ' . $this->model . ' (' . $this->year . ')';
    }

    // Scope untuk mobil yang tersedia
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    // Scope untuk mobil unggulan
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    // Scope untuk pencarian
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('brand', 'like', "%{$search}%")
              ->orWhere('model', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }
}
