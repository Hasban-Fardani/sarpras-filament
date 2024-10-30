<?php

namespace App\Models;

use Filament\Notifications\Notification;
use Filament\Support\Colors\Color;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class SubmissionItemDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function submissionItem()
    {
        return $this->belongsTo(SubmissionItem::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    protected static function boot()
    { 
        parent::boot();

        static::creating(function ($submissionItemDetail) {

            $submissionItemDetail->load(['submissionItem', 'item']);
            
            // check if item is exists on lastest submission item detail
            $last_submission_item =    $submissionItemDetail
                ->submissionItem
                ->details()
                ->where('item_id', $submissionItemDetail->item_id);
            if ($last_submission_item->exists()) 
            {
                Log::info('item is exists on lastest submission item detail ' . $submissionItemDetail->item_id);
                $last_submission_item->increment('qty', $submissionItemDetail->qty);
                $submissionItemDetail->delete();
                Log::info('delete ' . $submissionItemDetail->id);
                return false;
            }
        });
    }
}
