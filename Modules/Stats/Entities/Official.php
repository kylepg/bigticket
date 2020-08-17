<?php

namespace Modules\Stats\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Stats\Entities\Game;
use Modules\Tags\Entities\Tag;

class Official extends Model
{
    /**
     *
     * RELATIONS
     *
     */
    public function games()
    {
        return $this->belongsToMany(Game::class)->withTimestamps();
    }
    public function tags()
    {
        if(array_key_exists('Tags',Module::allEnabled())){
            return $this->morphedByMany(Tag::class,'taggable');
        }
        return collect([]);
    }
}
