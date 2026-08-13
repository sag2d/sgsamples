<?php

namespace App\Filament\Resources\Players\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;

/*
 * PlayerForm Filament admin panel configuration settings for the Team Manager application.
 * 
 * @author Scott Greenhagen
 * @version 1.0
 * @package Team Manager
 */
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
                    ->email()
                    ->rules(['email:strict,spoof']), // combines strict RFC checking with spoof detection
                TextInput::make('phone')
                    ->tel(),
            ]);
    }
}
