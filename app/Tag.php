<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Publications tagged by this.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function publications()
    {
        return $this->belongsToMany(Publication::class)->withTimestamps();
    }
}
