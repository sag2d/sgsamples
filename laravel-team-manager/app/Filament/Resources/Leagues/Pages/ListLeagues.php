<?php

namespace App\Filament\Resources\Leagues\Pages;

use App\Filament\Resources\Leagues\LeagueResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLeagues extends ListRecords
{
    protected static string $resource = LeagueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
