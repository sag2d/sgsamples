<?php

namespace App\Filament\Resources\Players\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PlayerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('team_id')
                    ->required()
                    ->numeric(),
                TextInput::make('first_name')
                    ->required(),
                TextInput::make('last_name')
                    ->required(),
                TextInput::make('address'),
                TextInput::make('city'),
                TextInput::make('state_id')
                    ->required()
                    ->numeric(),
                TextInput::make('zip'),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                TextInput::make('phone')
                    ->tel(),
            ]);
    }
}
