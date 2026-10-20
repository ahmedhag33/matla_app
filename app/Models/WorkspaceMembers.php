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
}
