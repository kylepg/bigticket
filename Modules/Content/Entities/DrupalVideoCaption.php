<?php

namespace Modules\Content\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;
use Modules\Content\Entities\DrupalVideo;
use Modules\Tags\Entities\Tag;

class DrupalVideoCaption extends Model
{
    use HasUuid;

    /**
     *
     * RELATIONS
     *
     */
    public function drupalVideo()
    {
        return $this->belongsTo(DrupalVideo::class);
    }
    public function tags()
    {
        if(array_key_exists('Tags',Module::allEnabled())){
            return $this->morphedByMany(Tag::class,'taggable');
        }
        return collect([]);
    }
}
