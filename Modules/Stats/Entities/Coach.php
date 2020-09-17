<?php

namespace Modules\Stats\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Tags\Entities\Tag;

class Coach extends Model
{
    /**
     *
     * RELATIONS
     *
     */
    public function tags()
    {
        if(array_key_exists('Tags',\Module::allEnabled())){
            return $this->morphToMany(Tag::class,'taggable');
        }
        return collect([]);
    }
}
