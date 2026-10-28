<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkspaceMembers extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     * */
    protected $table = 'workspace_members';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['workspace_id', 'member_id'];
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::booted();
        // set up model event hooks for workspace members
        static::creating(function ($workspaceMember) {
            // Automatically set the member_id to the currently authenticated member if available
            if (auth()->guard('member')->check()) {
                $workspaceMember->member_id = auth()->guard('member')->user()->id;
            }
        });
    }
}
