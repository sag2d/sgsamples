<?php

namespace App\Filament\Resources\Donations\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

/*
 * DonationInfoList Filament admin panel configuration settings.
 * 
 * @author Scott Greenhagen
 */
class DonationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('User'),
                TextEntry::make('subscription.stripe_id')
                    ->label('Stripe Subscription'),
                TextEntry::make('donor_name'),
                TextEntry::make('donor_email'),
                TextEntry::make('description'),
                TextEntry::make('amount'),
                TextEntry::make('currency'),
                TextEntry::make('status'),
                TextEntry::make('interval'),
                TextEntry::make('stripe_payment_intent_id')
                    ->label('Stripe Payment Intent ID'),
                TextEntry::make('stripe_payment_id')
                    ->label('Stripe Payment ID'),
                TextEntry::make('stripe_payment_method_id')
                    ->label('Stripe Payment Method ID'),
                TextEntry::make('stripe_customer_id')
                    ->label('Stripe Customer ID'),
                TextEntry::make('stripe_subscription_id')
                    ->label('Stripe Subscription ID'),
            ]);
    }
}
