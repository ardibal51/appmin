<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Merk extends Model
{
    // Nama tabel eksplisit (optional, kalau nggak pakai konvensi plural)
    protected $table = 'merks';

    // Primary key default 'id', jadi nggak perlu override
    // Auto-increment dan integer, jadi nggak perlu set $incrementing atau $keyType

    // Kolom yang boleh diisi massal
    protected $fillable = ['name'];
}