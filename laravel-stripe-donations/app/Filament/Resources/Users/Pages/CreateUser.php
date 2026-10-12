<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;

/*
 * CreateUser Filament admin panel configuration settings.
 * 
 * @author Scott Greenhagen
 */
class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
