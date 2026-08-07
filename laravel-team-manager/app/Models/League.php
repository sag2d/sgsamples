<?php

namespace App\Models;

use Database\Factories\LeagueFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
