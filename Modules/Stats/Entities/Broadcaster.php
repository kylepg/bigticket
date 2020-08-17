<?php

namespace Modules\Stats\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Stats\Entities\Game;
use Modules\Tags\Entities\Tag;

class Broadcaster extends Model
{
    /**
     *
     * RELATIONS
     *
     */
    public function games()
    {
        return $this->belongsToMany(Game::class)->withPivot('scope')->withTimestamps();
    }
    public function tags()
    {
        if(array_key_exists('Tags',Module::allEnabled())){
            return $this->morphedByMany(Tag::class,'taggable');
        }
        return collect([]);
    }
}
