<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workspace extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'workspaces';
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
        'workspace_type_id',
        'country_id',
        'created_by',
        'photo',
        'active',
        'created_at',
        'updated_at',
    ];
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::booted();
        // Automatically generate slug when creating a new workspace
        static::creating(function ($workspace) {
            $workspace->slug = str()->slug($workspace->name);
            // check if user is logged in
            if (!auth()->guard('member')->check()) {
                $workspace->created_by = auth()->guard('member')->user()->id;
            }
        });
    }
    /**
     * Get the type that owns the workspace.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function workspaceType()
    {
        return $this->belongsTo(WorkspaceType::class, 'workspace_type_id');
    }
    /**
     * Get the country that owns the workspace.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    /**
     * Get the creator of the workspace.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(Member::class, 'created_by');
    }
    /**
     * Get the members of the workspace.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * */
    public function members()
    {
        return $this->belongsToMany(
            Member::class,
            new WorkspaceMembers()->getTable(),
            'workspace_id',
            'member_id'
        );
    }
}
