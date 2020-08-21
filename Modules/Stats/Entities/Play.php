<?php

namespace Modules\Stats\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Stats\Entities\Game;
use Modules\Stats\Entities\Player;
use Modules\Stats\Entities\Team;
use Modules\Tags\Entities\Tag;

class Play extends Model
{
    /**
     *
     * RELATIONS
     *
     */
    public function game()
    {
        return $this->belongsTo(Game::class);
    }
    public function players()
    {
        return $this->belongsToMany(Player::class)->withPivot('role')->withTimestamps();
    }
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
    public function tags()
    {
        if(array_key_exists('Tags',\Module::allEnabled())){
            return $this->morphToMany(Tag::class,'taggable');
        }
        return collect([]);
    }

    /**
     *
     * HELPERS
     *
     */

    public function opponent()
    {
        return $this->player('opponent');
    }
    public function player($role = 'primary')
    {
        return $this->players()->where('role','=',$role)->first();
    }
    public function teammate()
    {
        return $this->player('teammate');
    }

    /**
     *
     * SCOPES
     *
     */

    //!! NOT WORKING !!//
    public function scopeWhereAssistedBy($builder,Player $player)
    {
        dd($builder->getModel());
        if(!empty($this->player('teammate'))){
            return $this->player('teammate')->where('player_id',$player->id);
        }
        else{
            $builder;
        }
    }
    public function scopeWhereAlleyOop($builder)
    {
        $builder->whereIn('event_type_id',[1,2])->whereIn('action_type_id',[43,52,100,106]);
    }
    public function scopeWhereBankShot($builder)
    {
        $builder->whereIn('event_type_id',[1,2])->whereIn('action_type_id',[66,67,81,82,83,84,85,93,94,95,96,102,104,105]);
    }
    public function scopeWhereDunk($builder)
    {
        $builder->whereIn('event_type_id',[1,2])->whereIn('action_type_id',[7,8,9,48,49,50,51,52,64,87,88,89,90,91,92,106,107,108,109,110]);
    }
    public function scopeWhereReverseDunk($builder)
    {
        $builder->whereIn('event_type_id',[1,2])->whereIn('action_type_id',[51,89,91,109,110]);
    }
    public function scopeWhereFadeaway($builder)
    {
        $builder->whereIn('event_type_id',[1,2])->whereIn('action_type_id',[63,83,86,105]);
    }
    public function scopeWhereFloater($builder)
    {
        $builder->whereIn('event_type_id',[1,2])->whereIn('action_type_id',[78,101,102]);
    }
    public function scopeWhereJumpShot($builder)
    {
        $builder->whereIn('event_type_id',[1,2])->whereIn('action_type_id',[1,2,45,46,47,77,78,79,80,101,102,103,104,105]);
    }
    public function scopeWhereLayup($builder)
    {
        $builder->whereIn('event_type_id',[1,2])->whereIn('action_type_id',[5,6,40,41,42,43,44,71,72,73,74,75,76,97,98,99,100]);
    }
    public function scopeWhere2Pointer($builder)
    {
        $builder->whereIn('event_type_id',[1,2])->where('option_1',3);
    }
    public function scopeWhere3Pointer($builder)
    {
        $builder->whereIn('event_type_id',[1,2])->where('option_1',3);
    }
    public function scopeWhereOnFastBreak($builder)
    {
        $builder->whereIn('event_type_id',[1,2])->where('option_2',1);
    }
    public function scopeWhereMade($builder)
    {
        $builder->where('event_type_id','=',1)
            ->orWhere(function($query){
                $query->where('event_type_id','=',3)
                    ->where('option_1','=',1);
            });
    }
    public function scopeWhereMake($builder)
    {
        $builder->whereMade();
    }
    public function scopeWhereMissed($builder)
    {
        $builder->where('event_type_id','=',2)
            ->orWhere(function($query){
                $query->where('event_type_id','=',3)
                    ->where('option_1','=',2);
            });
    }
    public function scopeWhereMiss($builder)
    {
        $builder->whereMissed();
    }
    public function scopeWhereRebound($builder)
    {
        $builder->where('event_type_id','=',4);
    }
    public function scopeWhereDefensiveRebound($builder)
    {
        $builder->where('event_type_id','=',4)->where('option_1',1);
    }
    public function scopeWhereOffensiveRebound($builder)
    {
        $builder->where('event_type_id','=',4)->where('option_1',2);
    }
    public function scopeWhereTurnover($builder)
    {
        $builder->where('event_type_id','=',5);
    }
    public function scopeWhereFoul($builder)
    {
        $builder->where('event_type_id','=',6)->whereNot('action_type_id',0);
    }
    public function scopeWhereViolation($builder)
    {
        $builder->where('event_type_id','=',7)->whereNot('action_type_id',0);
    }
    public function scopeWhereSubstitution($builder)
    {
        $builder->where('event_type_id','=',8);
    }
    public function scopeWhereTimeout($builder)
    {
        $builder->where('event_type_id','=',9)->whereNot('action_type_id',0);
    }
    public function scopeWhereJumpBall($builder)
    {
        $builder->where('event_type_id','=',10);
    }
    public function scopeWhereEjection($builder)
    {
        $builder->where('event_type_id','=',11)->whereNot('action_type_id',0);
    }
    public function scopeWhereFreeThrow($builder)
    {
        $builder->where('event_type_id','=',3);
    }
    public function scopeWhereLaneViolation($builder)
    {
        $builder->where('event_type_id','=',4)->where('option_1',6);
    }

}
