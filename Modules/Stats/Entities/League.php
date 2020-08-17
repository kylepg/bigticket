<?php

namespace Modules\Stats\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Stats\Entities\Season;
use Modules\Stats\Entities\Team;
use Modules\Tags\Entities\Tag;

class League extends Model
{
    /**
     *
     * RELATIONS
     *
     */
    public function seasons()
    {
        return $this->hasMany(Season::class);
    }
    public function teams()
    {
        return $this->hasMany(Team::class);
    }
    public function tags()
    {
        if(array_key_exists('Tags',Module::allEnabled())){
            return $this->morphedByMany(Tag::class,'taggable');
        }
        return collect([]);
    }
}
