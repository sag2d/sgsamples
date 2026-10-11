<?php

namespace App\Filament\Resources\Leagues\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

/*
 * LeagueInfoList Filament admin panel configuration settings for the Team Manager application.
 * 
 * @author Scott Greenhagen
 */
class LeagueInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
            ]);
    }
}
