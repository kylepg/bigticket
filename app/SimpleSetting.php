<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SimpleSetting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','value','type',
    ];

    /**
     *
     * GETTERS
     *
     */
    protected function getCastValueAttribute()
    {
        if($this->type === 'null'){
            return null;
        }
        elseif($this->type === 'boolean'){
            return ($this->value === 'true' || $this->value == 1) ? true : (($this->value === 'false' || $this->value == 0) ? false : null);
        }
        elseif($this->type === 'array'){
            return (float)$this->value;
        }
        elseif($this->type === 'date' || $this->type === 'date_time'){
            return Carbon::parse($this->value);
        }
        elseif($this->type === 'integer' || $this->type === 'int'){
            return (int)$this->value;
        }
        elseif($this->type === 'float' || $this->type === 'double' || $this->type === 'decimal'){
            return (float)$this->value;
        }
        return $this->value;
    }
}
