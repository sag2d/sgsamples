<?php

namespace App\Filament\Resources\Donations\Pages;

use App\Filament\Resources\Donations\DonationResource;
//use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

/**
 * ViewDonation class to display a single donation record.
 * 
 * @author Scott Greenhagen
 */
class ViewDonation extends ViewRecord
{
    protected static string $resource = DonationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //EditAction::make(),
        ];
    }
}
