<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class RequestItemDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function requestItem()
    {
        return $this->belongsTo(RequestItem::class);
    }

    protected static function boot()
    { 
        parent::boot();

        static::creating(function ($requestItemDetail) {

            $requestItemDetail->load(['requestItem', 'item']);
            
            // check if item is exists on lastest submission item detail
            $last_request_item =    $requestItemDetail
                ->requestItem
                ->details()
                ->where('item_id', $requestItemDetail->item_id);
            if ($last_request_item->exists()) 
            {
                Log::info('item is exists on lastest submission item detail ' . $requestItemDetail->item_id);
                $last_request_item->increment('qty', $requestItemDetail->qty);
                $requestItemDetail->delete();
                Log::info('delete ' . $requestItemDetail->id);
                return false;
            }
        });
    }
}
