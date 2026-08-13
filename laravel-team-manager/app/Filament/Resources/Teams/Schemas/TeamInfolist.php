<?php

namespace App\Filament\Resources\Teams\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

/*
 * TeamInfoList Filament admin panel configuration settings for the Team Manager application.
 * 
 * @author Scott Greenhagen
 * @version 1.0
 * @package Team Manager
 */
class TeamInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('league.name')
                ->label('League'),
                TextEntry::make('name'),
                TextEntry::make('mascot')
                    ->placeholder('-'),
            ]);
    }
}
