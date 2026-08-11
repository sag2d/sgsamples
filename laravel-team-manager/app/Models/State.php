<?php

namespace App\Models;

use Database\Factories\StateFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Player;

/**
 * State Model for the Team Manager application.
 * 
 * @author Scott Greenhagen
 * @version 1.0
 * @package Team Manager
 */
#[Fillable(['name', 'abbr'])]
class State extends Model
{
    /** @use HasFactory<StateFactory> */
    use HasFactory;

    /**
     * Get the Players for this State.
     */
    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }
}
