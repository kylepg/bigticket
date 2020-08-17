<?php

namespace Modules\Stats\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Stats\Entities\Game;
use Modules\Stats\Entities\League;
use Modules\Tags\Entities\Tag;

class Season extends Model
{
    /**
     *
     * RELATIONS
     *
     */
    public function games()
    {
        return $this->hasMany(Game::class)->orderBy('date_time','asc');
    }
    public function league()
    {
        return $this->belongsTo(League::class);
    }
    public function tags()
    {
        if(array_key_exists('Tags',Module::allEnabled())){
            return $this->morphedByMany(Tag::class,'taggable');
        }
        return collect([]);
    }
}
