<?php

namespace App\Models;

use App\Enums\GameTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Game extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'game_type' => GameTypeEnum::class,
        'game_state' => 'array',
    ];

    // --------------------------
    // QUERY BUILDER
    // --------------------------

    // --------------------------
    // HELPERS
    // --------------------------
    public function players(): BelongsToMany
    {
        return $this->belongsToMany(Player::class);
    }

    // --------------------------
    // HELPERS
    // --------------------------
    public function linkPlayers(Player $player1, Player $player2)
    {
        $this->players()->syncWithoutDetaching([$player1->id, $player2->id]);
    }

    // --------------------------
    // INTERFACES
    // --------------------------
}
