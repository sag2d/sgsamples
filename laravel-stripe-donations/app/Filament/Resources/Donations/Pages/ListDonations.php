<?php

namespace App\Filament\Resources\Donations\Pages;

use App\Filament\Resources\Donations\DonationResource;
//use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

/**
 * ListDonations class to display a list of donations.
 * 
 * @author Scott Greenhagen
 */
class ListDonations extends ListRecords
{
    protected static string $resource = DonationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //CreateAction::make(),
        ];
    }
}
