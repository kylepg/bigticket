<?php

namespace Modules\Stats\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Stats\Entities\Game;
use Modules\Stats\Entities\Player;
use Modules\Stats\Entities\Team;
use Modules\Tags\Entities\Tag;

class Play extends Model
{
    /**
     *
     * RELATIONS
     *
     */
    public function game()
    {
        return $this->belongsTo(Game::class);
    }
    public function players()
    {
        return $this->belongsToMany(Player::class)->withTimestamps();
    }
    public function team()
    {
        return $this->belongsTo(Team::class);
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
     * HELPERS
     *
     */

    public function opponent()
    {
        return $this->player('opponent');
    }
    public function player($role = 'primary')
    {
        return $this->players()->where('role','=',$role)->first();
    }
    public function teammate()
    {
        return $this->player('teammate');
    }
}
