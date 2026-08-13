<?php

namespace App\Filament\Resources\Players\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

/*
 * PlayerInfoList Filament admin panel configuration settings for the Team Manager application.
 * 
 * @author Scott Greenhagen
 * @version 1.0
 * @package Team Manager
 */
class PlayerInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('team.name')
                    ->label('Team'),
                TextEntry::make('first_name'),
                TextEntry::make('last_name'),
                TextEntry::make('address')
                    ->placeholder('-'),
                TextEntry::make('city')
                    ->placeholder('-'),
                TextEntry::make('state.abbr')
                ->label('State'),
                TextEntry::make('zip')
                    ->placeholder('-'),
                TextEntry::make('email')
                    ->label('Email address')
                    ->placeholder('-'),
                TextEntry::make('phone')
                    ->placeholder('-'),
            ]);
    }
}
