<?php

namespace App\Filament\Admin\Resources\OutgoingItemResource\Pages;

use App\Filament\Admin\Resources\OutgoingItemResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOutgoingItem extends CreateRecord
{
    protected static string $resource = OutgoingItemResource::class;
}
