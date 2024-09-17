<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomingItemDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function incomingItem()
    {
        return $this->belongsTo(IncomingItem::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
