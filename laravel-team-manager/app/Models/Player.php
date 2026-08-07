<?php

namespace App\Models;

use Database\Factories\PlayerFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['team_id', 'first_name', 'last_name', 'address', 'city', 'state_id', 'zip', 'email', 'phone'])]
class Player extends Model
{
    /** @use HasFactory<PlayerFactory> */
    use HasFactory;
}
