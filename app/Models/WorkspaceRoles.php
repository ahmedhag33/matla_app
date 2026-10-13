<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkspaceRoles extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'workspace_roles';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'name_en',
        'slug',
        'level',
    ];
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::booted();
        // Automatically generate slug when creating a new workspace role
        static::creating(function ($workspaceRole) {
            // Generate slug from name
            $workspaceRole->slug = str()->slug($workspaceRole->name);
        });
    }
}
