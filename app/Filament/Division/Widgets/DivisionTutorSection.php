<?php

namespace App\Filament\Division\Widgets;

use Filament\Widgets\Widget;

class DivisionTutorSection extends Widget
{
    protected static string $view = 'filament.division.widgets.division-tutor-section';

    protected int | string | array $columnSpan = 'full';
}
