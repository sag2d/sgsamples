<?php

namespace App\Filament\Resources\Players\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;

class PlayerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('team_id')
                    ->relationship('team', 'name') 
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('first_name')
                    ->required(),
                TextInput::make('last_name')
                    ->required(),
                TextInput::make('address'),
                TextInput::make('city'),
                Select::make('state_id')
                    ->relationship('state', 'abbr') 
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('zip'),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                TextInput::make('phone')
                    ->tel(),
            ]);
    }
}
