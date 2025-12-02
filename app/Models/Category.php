<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Nama tabel default: 'categories' → nggak perlu override

    // Kolom yang boleh diisi massal
    protected $fillable = ['name'];
}