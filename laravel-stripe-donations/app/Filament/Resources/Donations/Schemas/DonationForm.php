<?php

namespace App\Filament\Resources\Donations\Schemas;

use App\Enums\DonationStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DonationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('subscription_id')
                    ->relationship('subscription', 'stripe_id')
                    ->searchable()
                    ->preload(),
                TextInput::make('donor_name')
                    ->required(),
                TextInput::make('donor_email')
                    ->email()
                    ->rules(['email:strict,spoof']) // combines strict RFC checking with spoof detection
                    ->required(),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                TextInput::make('currency')
                    ->required()
                    ->default('USD'),
                Select::make('status')
                    ->options(DonationStatus::class)
                    ->default('pending')
                    ->required(),
                TextInput::make('interval'),
                TextInput::make('description'),
                TextInput::make('stripe_payment_intent_id')
                    ->label('Stripe Payment Intent ID'),
                TextInput::make('stripe_payment_id')
                    ->label('Stripe Payment ID'),
                TextInput::make('stripe_payment_method_id')
                    ->label('Stripe Payment Method ID'),
                TextInput::make('stripe_customer_id')
                    ->label('Stripe Customer ID'),
                TextInput::make('stripe_subscription_id')
                    ->label('Stripe Subscription ID'),
            ]);
    }
}
