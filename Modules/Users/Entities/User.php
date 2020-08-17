<?php

namespace Modules\Users\Entities;

use Modules\Tags\Entities\Tag;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\HasUuid;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasUuid;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','uuid','email','provider','provider_id','password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     *
     * RELATIONS
     *
     */
    public function tags()
    {
        if(array_key_exists('Tags',Module::allEnabled())){
            return $this->morphedByMany(Tag::class,'taggable');
        }
        return collect([]);
    }
}
