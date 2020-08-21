<?php

namespace Modules\Content\Entities;

use Illuminate\Database\Eloquent\Model;

use Modules\Content\Entities\DrupalGallery;
use Modules\Tags\Entities\Tag;
use App\Traits\HasUuid;

class DrupalGalleryImage extends Model
{
    use HasUuid;

    /**
     *
     * RELATIONS
     *
     */
    public function drupalGalleries()
    {
        return $this->belongsToMany(DrupalGallery::class)->withTimestamps();
    }
    public function tags()
    {
        if(array_key_exists('Tags',\Module::allEnabled())){
            return $this->morphToMany(Tag::class,'taggable');
        }
        return collect([]);
    }
}
