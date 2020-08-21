<?php

namespace Modules\Stats\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Stats\Entities\Game;
use Modules\Stats\Entities\Player;
use Modules\Stats\Entities\Team;
use Modules\Tags\Entities\Tag;

class BoxScore extends Model
{
    /**
     *
     * The relationships to return by default.
     *
     */
    protected $with = ['game'];

    /**
     *
     * RELATIONS
     *
     */
    public function game()
    {
        return $this->belongsTo(Game::class);
    }
    public function player()
    {
        return $this->belongsTo(Player::class);
    }
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
    public function tags()
    {
        if(array_key_exists('Tags',\Module::allEnabled())){
            return $this->morphToMany(Tag::class,'taggable');
        }
        return collect([]);
    }
}
