<?php

namespace App\Filament\Resources\Leagues\Pages;

use App\Filament\Resources\Leagues\LeagueResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewLeague extends ViewRecord
{
    protected static string $resource = LeagueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
