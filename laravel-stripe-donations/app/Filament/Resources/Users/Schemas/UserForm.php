<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

/*
 * UserForm Filament admin panel configuration settings.
 * 
 * @author Scott Greenhagen
 */
class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('password')
                    ->password()
                    ->revealable() // add show/hide password toggle
                    ->required(fn (string $operation): bool => $operation === 'create') // required only when creating a new record
                    ->dehydrated(fn (?string $state) => filled($state)) // only send to the database if not empty
                    ->mutateDehydratedStateUsing(fn (string $state) => Hash::make($state)), // automatically hash the password before saving
                Toggle::make('is_admin')
                    ->required(),
                DateTimePicker::make('email_verified_at')
                    ->disabled(),
                TextInput::make('stripe_id')
                    ->label('Stripe Customer ID')
                    ->disabled(),
                TextInput::make('pm_type')
                    ->label('Payment Method Type')
                    ->disabled(),
                TextInput::make('pm_last_four')
                    ->label('Last Four Digits of Payment Method')
                    ->disabled(),
                DateTimePicker::make('trial_ends_at')
                    ->disabled(),
            ]);
    }
}
