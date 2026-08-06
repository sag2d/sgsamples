<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['league_id', 'name', 'mascot'])]
class Team extends Model
{
    //
}
