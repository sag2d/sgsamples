<?php

namespace App\Models;

use Database\Factories\LeagueFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * League Model for the Team Manager application.
 * 
 * @author Scott Greenhagen
 * @version 1.0
 * @package Team Manager
 */
#[Fillable(['name'])]
class League extends Model
{
    /** @use HasFactory<LeagueFactory> */
    use HasFactory;

    /**
     * Get the Teams for this League.
     */
    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }
}
