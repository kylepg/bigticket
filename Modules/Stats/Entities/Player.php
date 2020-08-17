<?php

namespace Modules\Stats\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Stats\Entities\BoxScore;
use Modules\Stats\Entities\Game;
use Modules\Stats\Entities\Team;
use Modules\Tags\Entities\Tag;

class Player extends Model
{
    /**
     *
     * RELATIONS
     *
     */
    public function boxScores()
    {
        return $this->hasMany(BoxScore::class);
    }
    public function games()
    {
        return $this->hasManyThrough(Game::class,BoxScore::class);
    }
    public function teams()
    {
        return $this->belongsToMany(Team::class)->withTimestamps();
    }
    public function tags()
    {
        if(array_key_exists('Tags',Module::allEnabled())){
            return $this->morphedByMany(Tag::class,'taggable');
        }
        return collect([]);
    }
}
