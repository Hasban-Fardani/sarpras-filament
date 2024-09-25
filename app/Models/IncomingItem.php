<?php

namespace App\Models;

use Filament\Actions\StaticAction;
use Filament\Notifications\Actions\ActionGroup;
use Filament\Notifications\Notification;
use Filament\Support\Colors\Color;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomingItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function details()
    {
        return $this->hasMany(IncomingItemDetail::class);
    }
    public function getTotalItemsAttribute()
    {
        return $this->details->sum('qty');
    }

    protected static function booted()
    {
        static::created(function (IncomingItem $incomingItem) {
            $notifiables = User::whereIn('role', ['supervisor', 'admin'])->get();
            $notifiables->each(function ($notifiable) use ($incomingItem) {
                // generate url to see detail by role
                $url = $notifiable->role == 'admin' ?
                    route('filament.admin.resources.incoming-items.view', ['record' => $incomingItem]) :
                    route('filament.supervisor.resources.incoming-items.index');

                $notifiable->notify(
                    Notification::make()
                        ->title('Barang Masuk Baru')
                        ->body('Barang Masuk Baru ' . $incomingItem->id)
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
