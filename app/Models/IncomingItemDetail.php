<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

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

    protected static function boot()
    { 
        parent::boot();

        static::creating(function ($incomingItemDetail) {

            $incomingItemDetail->load(['incomingItem', 'item']);
            
            // check if item is exists on lastest incoming item detail
            $last_incoming_item =    $incomingItemDetail
                ->incomingItem
                ->details()
                ->where('item_id', $incomingItemDetail->item_id);
            if ($last_incoming_item->exists()) 
            {
                Log::info('item is exists on lastest incoming item detail ' . $incomingItemDetail->item_id);
                $last_incoming_item->increment('qty', $incomingItemDetail->qty);
                $incomingItemDetail->delete();
                Log::info('delete ' . $incomingItemDetail->id);
                return false;
            }
        });
    }
}
