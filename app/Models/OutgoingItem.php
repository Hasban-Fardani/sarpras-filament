<?php

namespace App\Models;

use Filament\Actions\StaticAction;
use Filament\Notifications\Actions\ActionGroup;
use Filament\Notifications\Notification;
use Filament\Support\Colors\Color;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutgoingItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function details()
    {
        return $this->hasMany(OutgoingItemDetail::class);
    }
    
    public function operator()
    {
        return $this->belongsTo(Employee::class, 'operator_id');
    }

    public function division()
    {
        return $this->belongsTo(Employee::class, 'division_id');
    }


    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    // notify user when created
    protected static function booted()
    {
        static::created(function (OutgoingItem $outgoingItem) {
            $notifiables = User::whereIn('role', ['supervisor', 'admin'])->get();
            $notifiables->each(function ($notifiable) use ($outgoingItem) {
                // generate url to see detail by role
                $url = $notifiable->role == 'admin' ?
                    route('filament.admin.resources.outgoing-items.index') :
                    route('filament.supervisor.resources.outgoing-items.index');

                $notifiable->notify(
                    Notification::make()
                        ->title('Barang Keluar Baru')
                        ->body('Barang Keluar Baru ' . $outgoingItem->id)
                        ->color(Color::Blue)
                        // ->actions(
                        //     ActionGroup::make([
                        //         StaticAction::make('lihat')->url($url)->name('Lihat')
                        //     ])
                        // )
                        ->toDatabase(),
                );
            });
        });
    }
}
