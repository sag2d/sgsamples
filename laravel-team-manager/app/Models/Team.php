<?php

namespace App\Models;

use Database\Factories\TeamFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['Team_id', 'name', 'mascot'])]
class Team extends Model
{
    /** @use HasFactory<TeamFactory> */
    use HasFactory;
}
