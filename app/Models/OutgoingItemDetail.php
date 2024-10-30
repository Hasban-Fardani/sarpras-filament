<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

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

    protected static function boot()
    { 
        parent::boot();

        static::creating(function ($outgoingItemDetail) {

            $outgoingItemDetail->load(['outgoingItem', 'item']);
            
            // check if item is exists on lastest outgoing item detail
            $last_outgoing_item =    $outgoingItemDetail
                ->outgoingItem
                ->details()
                ->where('item_id', $outgoingItemDetail->item_id);
            if ($last_outgoing_item->exists()) 
            {
                Log::info('item is exists on lastest outgoing item detail ' . $outgoingItemDetail->item_id);
                $last_outgoing_item->increment('qty', $outgoingItemDetail->qty);
                $outgoingItemDetail->delete();
                Log::info('delete ' . $outgoingItemDetail->id);
                return false;
            }
        });
    }
}
