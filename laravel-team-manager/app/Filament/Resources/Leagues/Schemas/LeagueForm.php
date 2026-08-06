<?php

namespace App\Filament\Resources\Leagues\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LeagueForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
            ]);
    }
}
