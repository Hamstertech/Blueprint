<?php

namespace App\Models;

use App\Enums\GameTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'session_id',
    ];

    // --------------------------
    // QUERY BUILDER
    // --------------------------

    // --------------------------
    // HELPERS
    // --------------------------
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function games(): BelongsToMany
    {
        return $this->belongsToMany(Game::class);
    }

    // --------------------------
    // HELPERS
    // --------------------------
    public function sharesGameWith(Player $player)
    {
        return $this->games()
            ->whereHas('players', function ($query) use ($player) {
                $query->where('players.session_id', $player->session_id);
            })
            ->exists();
    }

    public function sharedGamesWith(Player $player, GameTypeEnum $type)
    {
        return $this->games()
            ->where('game_type', $type)
            ->whereHas('players', function ($query) use ($player) {
                $query->where('players.session_id', $player->session_id);
            })->first();
    }

    public function runningGame(GameTypeEnum $gameType)
    {
        return $this->games()->where('game_type', $gameType->value)->latest()->first();
    }

    // --------------------------
    // INTERFACES
    // --------------------------
}
