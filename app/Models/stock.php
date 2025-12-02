<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'merk_code',
        'unit',
        'unit_price',
        'initial_stock',
        'stock_remaining',
    ];

    // Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke merk
    public function merk()
    {
        return $this->belongsTo(Merk::class, 'merk_code', 'name');
    }

    // Relasi ke unit
    public function unitData()
    {
        return $this->belongsTo(Unit::class, 'unit', 'name');
    }
}
