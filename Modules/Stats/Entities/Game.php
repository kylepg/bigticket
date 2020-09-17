<?php

namespace Modules\Stats\Entities;

use Illuminate\Database\Eloquent\Model;

use Modules\Content\Entities\DrupalArticle;
use Modules\Content\Entities\DrupalVideo;

use Modules\Stats\Entities\Arena;
use Modules\Stats\Entities\BoxScore;
use Modules\Stats\Entities\Broadcaster;
use Modules\Stats\Entities\Official;
use Modules\Stats\Entities\Play;
use Modules\Stats\Entities\Season;
use Modules\Stats\Entities\Team;

use Modules\Tags\Entities\Tag;

class Game extends Model
{
    /**
     *
     * The relationships to return by default.
     *
     */
    protected $with = ['arena','broadcasters','teams'];

    /**
     *
     * Date casting.
     *
     */
    protected $dates = ['date_time'];

    /**
     *
     * The methods to run before returning model.
     *
     */
    protected $appends = ['drupal_videos','drupal_articles'];

    /**
     *
     * RELATIONS
     *
     */
    public function arena()
    {
        return $this->belongsTo(Arena::class);
    }
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class)->withPivot('value')->withTimestamps();
    }
    public function boxScores()
    {
        return $this->hasMany(BoxScore::class);
    }
    public function broadcasters()
    {
        return $this->belongsToMany(Broadcaster::class)->withPivot('scope')->withTimestamps();
    }
    public function officials()
    {
        return $this->belongsToMany(Official::class)->withTimestamps();
    }
    public function plays()
    {
        return $this->hasMany(Play::class);
    }
    public function season()
    {
        return $this->belongsTo(Season::class);
    }
    public function teams()
    {
        return $this->belongsToMany(Team::class)->withPivot('role','s','q1','q2','q3','q4','ot1','ot2','ot3','ot4','ot5','ot6','ot7','ot8','ot9','ot10','ftout','stout','fga','fgm','tpa','tpm','fta','ftm','oreb','dreb','reb','ast','stl','blk','pf','tov','fbpts','fbptsa','fbptsm','pip','pipa','pipm','ble','bpts','tf','scp','tmreb','tmtov','potov')->withTimestamps();
    }
    public function tags()
    {
        if(array_key_exists('Tags',\Module::allEnabled())){
            return $this->morphToMany(Tag::class,'taggable');
        }
        return collect([]);
    }
    public function drupalArticles()
    {
        if(array_key_exists('Tags',\Module::allEnabled()) && array_key_exists('Content',\Module::allEnabled())){
            $gid = $this->gid;
            $articles = DrupalArticle::whereHas('tags',function($query) use ($gid) {
                $query->where('type','=','game_id')->where('name','=',$gid);
            });
            return $articles;
        }
        return collect([]);
    }
    public function drupalVideos()
    {
        if(array_key_exists('Tags',\Module::allEnabled()) && array_key_exists('Content',\Module::allEnabled())){
            $gid = $this->gid;
            $videos = DrupalVideo::whereHas('tags',function($query) use ($gid) {
                $query->where('type','=','game_id')->where('name','=',$gid);
            });
            return $videos;
        }
        return collect([]);
    }

    /**
     *
     * GETTERS
     *
     */
    protected function getAwayAttribute()
    {
        return $this->teams()->wherePivot('role','=','visitor')->first();
    }
    protected function getVisitorAttribute()
    {
        return $this->teams()->wherePivot('role','=','visitor')->first();
    }
    protected function getHomeAttribute()
    {
        return $this->teams()->wherePivot('role','=','home')->first();
    }
    protected function getCelticsAttribute()
    {
        return $this->teams()->where('abbreviation','=','BOS')->first();
    }
    protected function getOpponentAttribute()
    {
        return $this->teams()->where('abbreviation','!=','BOS')->first();
    }
    protected function getTelevisionAttribute()
    {
        return $this->broadcasters()->where('type','=','tv')->get();
    }
    protected function getRadioAttribute()
    {
        return $this->broadcasters()->where('type','=','radio')->get();
    }
    protected function getSeasonYearAttribute()
    {
        return $this->season->start_year;
    }
    public function getDrupalArticlesAttribute()
    {
        return $this->drupalArticles()->get()->map(function($article){
            $filtered = [
                'title' => $article->title,
                'description' => $article->description
            ];
            return $filtered;
        });
    }
    public function getDrupalVideosAttribute()
    {
        return $this->drupalVideos()->get()->map(function($video){
            $filtered = [
                'title' => $video->title,
                'description' => $video->description
            ];
            return $filtered;
        });
    }

    /**
     *
     * HELPERS
     *
     */
    public function findBroadcasters($scope = [],$type = null)
    {
        if(!empty($type)){
            return $this->broadcasters()->whereIn('broadcaster_game.scope',$scope)->where('type','=',$type)->get();
        }
        else {
            return $this->broadcasters()->whereIn('broadcaster_game.scope',$scope)->get();
        }
    }
}
