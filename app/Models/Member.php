<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Member extends Authenticatable
{
    use Notifiable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'members';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'slug',
        'password',
        'phone',
        'address',
        'photo',
        'workspace_role_id',
        'email_verified_at',
        'remember_token',
        'created_at',
        'updated_at'
    ];
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        // create slug from name when creating a new member
        static::creating(function ($member) {
            $member->slug = str()->slug($member->name);
        });
    }
    /**
     *  Get the role that the member belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(WorkspaceRoles::class, 'workspace_role_id');
    }
    /**
     * Get the verfication codes for the member.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function verfication_codes()
    {
        return $this->hasMany(MemberVerficationCodes::class, 'member_id');
    }
    /**
     * Get the workspaces that the member belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function workspaces()
    {
        return $this->belongsToMany(
            Workspace::class,
            new WorkspaceMembers()->getTable(),
            'member_id',
            'workspace_id'
        );
    }
}
