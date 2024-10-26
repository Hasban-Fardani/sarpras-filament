<?php

namespace App\Models;

use Filament\Actions\StaticAction;
use Filament\Notifications\Actions\ActionGroup;
use Filament\Notifications\Notification;
use Filament\Support\Colors\Color;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function division()
    {
        return $this->belongsTo(Employee::class, 'division_id');
    }

    public function operator()
    {
        return $this->belongsTo(Employee::class, 'operator_id');
    }

    public function details()
    {
        return $this->hasMany(RequestItemDetail::class);
    }

    public function getTotalItemsAttribute()
    {
        return $this->details->sum('qty');
    }

    protected static function booted()
    {
        static::updated(function (RequestItem $requestItem) {
            if ($requestItem->status != 'diajukan') {
                return; 
            }
            $notifiables = User::whereIn('role', ['supervisor', 'admin'])->get();
            $notifiables->each(function ($notifiable) use ($requestItem) {
                // generate url to see detail by role
                $url = $notifiable->role == 'admin' ?
                    route('filament.admin.resources.request-items.index') :
                    route('filament.supervisor.resources.request-items.index');

                $notifiable->notify(
                    Notification::make()
                        ->title('Permintaan Barang Baru')
                        ->body('Permintaan Barang Baru ' . $requestItem->id)
                        ->color(Color::Blue)
                        // ->actions([
                        //     ActionGroup::make([
                        //         StaticAction::make('lihat')->url($url)->name('Lihat')
                        //     ])
                        // ])
                        ->toDatabase(),
                );
            });
        });
    }
}
