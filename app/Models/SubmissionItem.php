<?php

namespace App\Models;

use Filament\Actions\StaticAction;
use Filament\Notifications\Actions\ActionGroup;
use Filament\Notifications\Notification;
use Filament\Support\Colors\Color;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmissionItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function details()
    {
        return $this->hasMany(SubmissionItemDetail::class);
    }

    public function division()
    {
        return $this->belongsTo(Employee::class, 'division_id');
    }

    public function getTotalItemsAttribute()
    {
        return $this->details->sum('qty');
    }

    public function getTotalItemsAccAttribute()
    {
        return $this->details->sum('qty_acc');
    }

    protected static function booted()
    {
        static::created(function (SubmissionItem $submissionItem) {
            $notifiables = User::whereIn('role', ['supervisor', 'admin'])->get();
            $notifiables->each(function ($notifiable) use ($submissionItem) {
                // generate url to see detail by role
                $url = $notifiable->role == 'admin' ?
                    route('filament.admin.resources.submission-items.index') :
                    route('filament.supervisor.resources.submission-items.index');

                $notifiable->notify(
                    Notification::make()
                        ->title('Permintaan Barang Baru')
                        ->body('Permintaan Barang Baru ' . $submissionItem->id)
                        ->color(Color::Blue)
                        // its will be error, ket 'name' is not defined
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
