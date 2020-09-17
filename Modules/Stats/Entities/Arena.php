<?php

namespace Modules\Stats\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Stats\Entities\Game;
use Modules\Stats\Entities\Team;
use Modules\Tags\Entities\Tag;

class Arena extends Model
{
    /**
     *
     * RELATIONS
     *
     */
    public function games()
    {
        return $this->hasMany(Game::class);
    }
    public function teams()
    {
        return $this->hasMany(Team::class);
    }
    public function tags()
    {
        if(array_key_exists('Tags',\Module::allEnabled())){
            return $this->morphToMany(Tag::class,'taggable');
        }
        return collect([]);
    }

    /**
     *
     * GETTERS
     *
     */
    protected function getFullArenaStringAttribute()
    {
        return $this->name.', '.$this->city.', '.$this->state;
    }
}
