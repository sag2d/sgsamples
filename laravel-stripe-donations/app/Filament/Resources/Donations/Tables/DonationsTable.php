<?php

namespace App\Filament\Resources\Donations\Tables;

use App\Models\Donation;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
// use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Stripe\Exception\ApiErrorException;

/*
 * DonationsTable Filament admin panel configuration settings.
 *
 * @author Scott Greenhagen
 */
class DonationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with('subscription'))
            ->columns([
                TextColumn::make('user.name')
                    ->searchable(),
                TextColumn::make('donor_name')
                    ->searchable(),
                TextColumn::make('donor_email')
                    ->searchable(),
                TextColumn::make('description')
                    ->searchable(),
                TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('currency')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->searchable(),
                TextColumn::make('interval')
                    ->searchable(),
                /*
                TextColumn::make('subscription.stripe_id')
                    ->searchable(),
                TextColumn::make('stripe_payment_intent_id')
                    ->searchable(),
                TextColumn::make('stripe_payment_id')
                    ->searchable(),
                TextColumn::make('stripe_payment_method_id')
                    ->searchable(),
                TextColumn::make('stripe_customer_id')
                    ->searchable(),
                TextColumn::make('stripe_subscription_id')
                    ->searchable(),
                */
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                // EditAction::make(),
                Action::make('cancelRecurringDonation')
                    ->label(__('Cancel recurring donation'))
                    ->icon(Heroicon::XMark)
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading(__('Cancel this recurring donation?'))
                    ->modalDescription(__('Cancellation takes effect at the end of the current billing period.'))
                    ->visible(self::canCancelRecurringDonation(...))
                    ->action(self::cancelRecurringDonation(...)),
            ])
            ->recordActionsAlignment('start')
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * Determine whether a donation has an active recurring subscription.
     */
    private static function canCancelRecurringDonation(Donation $record): bool
    {
        $subscription = $record->subscription;

        return $record->interval !== null
            && $subscription !== null
            && in_array($subscription->stripe_status, ['active', 'trialing'], true)
            && $subscription->active()
            && ! $subscription->canceled();
    }

    /**
     * Refresh and schedule cancellation of an active recurring subscription.
     */
    private static function cancelRecurringDonation(Donation $record): void
    {
        $subscription = $record->subscription;

        if ($record->interval === null || $subscription === null) {
            Notification::make()
                ->warning()
                ->title(__('This donation has no recurring subscription.'))
                ->send();

            return;
        }

        try {
            $subscription->syncStripeStatus();

            if (! in_array($subscription->stripe_status, ['active', 'trialing'], true)
                || ! $subscription->active()
                || $subscription->canceled()) {
                Notification::make()
                    ->warning()
                    ->title(__('This recurring donation is no longer active.'))
                    ->send();

                return;
            }

            $subscription->cancel();

            Notification::make()
                ->success()
                ->title(__('Cancellation scheduled'))
                ->body(__('The subscription will end at the end of its current billing period.'))
                ->send();
        } catch (ApiErrorException $exception) {
            report($exception);

            Notification::make()
                ->danger()
                ->title(__('Cancellation failed'))
                ->body(__('Stripe could not cancel this subscription. Please try again.'))
                ->send();
        }
    }
}
