<?php

namespace Modules\Stats\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Stats\Entities\Arena;
use Modules\Stats\Entities\BoxScore;
use Modules\Stats\Entities\Game;
use Modules\Stats\Entities\League;
use Modules\Stats\Entities\Player;
use Modules\Tags\Entities\Tag;

class Team extends Model
{
    /**
     *
     * RELATIONS
     *
     */
    public function arena()
    {
        return $this->belongsTo(Arena::class);
    }
    public function boxScores()
    {
        return $this->hasMany(BoxScore::class);
    }
    public function games()
    {
        return $this->belongsToMany(Game::class)->withPivot('role','fga','fgm','tpa','tpm','fta','ftm','oreb','dreb','reb','ast','stl','blk','pf','tov','fbpts','fbptsa','fbptsm','pip','pipa','pipm','ble','bpts','tf','scp','tmreb','tmtov','potov')->withTimestamps();
    }
    public function league()
    {
        return $this->belongsTo(League::class);
    }
    public function players()
    {
        return $this->hasMany(Player::class);
    }
    public function tags()
    {
        if(array_key_exists('Tags',Module::allEnabled())){
            return $this->morphedByMany(Tag::class,'taggable');
        }
        return collect([]);
    }

    /**
     *
     * GETTERS
     *
     */
    protected function getFullNameAttribute()
    {
        return $this->location.' '.$this->name;
    }
}
