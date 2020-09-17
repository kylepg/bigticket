<?php

namespace Modules\Tags\Entities;

use Illuminate\Database\Eloquent\Model;

use Modules\Users\Entities\User;

use Modules\Content\Entities\DrupalArticle;
use Modules\Content\Entities\DrupalAuthor;
use Modules\Content\Entities\DrupalGallery;
use Modules\Content\Entities\DrupalGalleryImage;
use Modules\Content\Entities\DrupalVideo;
use Modules\Content\Entities\DrupalVideoCaption;

use Modules\Stats\Entities\Arena;
use Modules\Stats\Entities\BoxScore;
use Modules\Stats\Entities\Broadcaster;
use Modules\Stats\Entities\Coach;
use Modules\Stats\Entities\Game;
use Modules\Stats\Entities\League;
use Modules\Stats\Entities\Official;
use Modules\Stats\Entities\Play;
use Modules\Stats\Entities\Player;
use Modules\Stats\Entities\Season;
use Modules\Stats\Entities\Team;

use App\Traits\HasUuid;

class Tag extends Model
{
    use HasUuid;

    /**
     *
     * RELATIONS
     *
     */

    public function users()
    {
        if(array_key_exists('Users',\Module::allEnabled())){
            return $this->morphedByMany(User::class,'taggable');
        }
        return collect([]);
    }



    public function drupalArticles()
    {
        if(array_key_exists('Content',\Module::allEnabled())){
            return $this->morphedByMany(DrupalArticle::class,'taggable');
        }
        return collect([]);
    }
    public function drupalAuthors()
    {
        if(array_key_exists('Content',\Module::allEnabled())){
            return $this->morphedByMany(DrupalAuthor::class,'taggable');
        }
        return collect([]);
    }
    public function drupalGalleries()
    {
        if(array_key_exists('Content',\Module::allEnabled())){
            return $this->morphedByMany(DrupalGallery::class,'taggable');
        }
        return collect([]);
    }
    public function drupalGalleryImages()
    {
        if(array_key_exists('Content',\Module::allEnabled())){
            return $this->morphedByMany(DrupalGalleryImage::class,'taggable');
        }
        return collect([]);
    }
    public function drupalVideos()
    {
        if(array_key_exists('Content',\Module::allEnabled())){
            return $this->morphedByMany(DrupalVideo::class,'taggable');
        }
        return collect([]);
    }
    public function drupalVideoCaptions()
    {
        if(array_key_exists('Content',\Module::allEnabled())){
            return $this->morphedByMany(DrupalVideoCaption::class,'taggable');
        }
        return collect([]);
    }



    public function arenas()
    {
        if(array_key_exists('Stats',\Module::allEnabled())){
            return $this->morphedByMany(Arena::class,'taggable');
        }
        return collect([]);
    }
    public function boxScores()
    {
        if(array_key_exists('Stats',\Module::allEnabled())){
            return $this->morphedByMany(BoxScore::class,'taggable');
        }
        return collect([]);
    }
    public function broadcasters()
    {
        if(array_key_exists('Stats',\Module::allEnabled())){
            return $this->morphedByMany(Broadcaster::class,'taggable');
        }
        return collect([]);
    }
    public function coaches()
    {
        if(array_key_exists('Stats',\Module::allEnabled())){
            return $this->morphedByMany(Coach::class,'taggable');
        }
        return collect([]);
    }
    public function games()
    {
        if(array_key_exists('Stats',\Module::allEnabled())){
            return $this->morphedByMany(Game::class,'taggable');
        }
        return collect([]);
    }
    public function leagues()
    {
        if(array_key_exists('Stats',\Module::allEnabled())){
            return $this->morphedByMany(League::class,'taggable');
        }
        return collect([]);
    }
    public function officials()
    {
        if(array_key_exists('Stats',\Module::allEnabled())){
            return $this->morphedByMany(Official::class,'taggable');
        }
        return collect([]);
    }
    public function plays()
    {
        if(array_key_exists('Stats',\Module::allEnabled())){
            return $this->morphedByMany(Play::class,'taggable');
        }
        return collect([]);
    }
    public function players()
    {
        if(array_key_exists('Stats',\Module::allEnabled())){
            return $this->morphedByMany(Player::class,'taggable');
        }
        return collect([]);
    }
    public function seasons()
    {
        if(array_key_exists('Stats',\Module::allEnabled())){
            return $this->morphedByMany(Season::class,'taggable');
        }
        return collect([]);
    }
    public function teams()
    {
        if(array_key_exists('Stats',\Module::allEnabled())){
            return $this->morphedByMany(Team::class,'taggable');
        }
        return collect([]);
    }
}
