<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkspaceType extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'workspace_types';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'slug',
        'description',
        'photo',
        'active'
    ];
}
