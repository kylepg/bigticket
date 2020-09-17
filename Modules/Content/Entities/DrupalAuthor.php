<?php

namespace Modules\Content\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

use Modules\Content\Entities\DrupalArticle;
use Modules\Content\Entities\DrupalGallery;
use Modules\Content\Entities\DrupalVideo;
use Modules\Tags\Entities\Tag;

class DrupalAuthor extends Model
{
    use HasUuid;

    /**
     *
     * RELATIONS
     *
     */
    public function drupalArticles()
    {
        return $this->hasMany(DrupalArticle::class);
    }
    public function drupalGalleries()
    {
        return $this->hasMany(DrupalGallery::class);
    }
    public function drupalVideos()
    {
        return $this->hasMany(DrupalVideo::class);
    }
    public function tags()
    {
        if(array_key_exists('Tags',\Module::allEnabled())){
            return $this->morphToMany(Tag::class,'taggable');
        }
        return collect([]);
    }
}
