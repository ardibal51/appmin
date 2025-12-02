<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseRequest extends Model
{
    use SoftDeletes;

    protected $fillable = ['purpose', 'requested_by', 'status'];

    public function items()
    {
        return $this->hasMany(PurchaseRequestItem::class);
    }
}

