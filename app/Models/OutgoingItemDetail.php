<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutgoingItemDetail extends Model
{
    protected $guarded = ['id'];
    

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function outgoingItem()
    {
        return $this->belongsTo(OutgoingItem::class);
    }
}
