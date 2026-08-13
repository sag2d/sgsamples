<?php

namespace App\Filament\Resources\Leagues\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

/*
 * LeagueForm Filament admin panel configuration settings for the Team Manager application.
 * 
 * @author Scott Greenhagen
 * @version 1.0
 * @package Team Manager
 */
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
