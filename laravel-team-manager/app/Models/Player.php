<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['team_id', 'first_name', 'last_name', 'address', 'city', 'state_id', 'zip', 'email', 'phone'])]
class Player extends Model
{
    //
}
