<?php

namespace App\Filament\Resources\Teams\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TeamInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('league_id')
                    ->numeric(),
                TextEntry::make('name'),
                TextEntry::make('mascot')
                    ->placeholder('-'),
            ]);
    }
}
