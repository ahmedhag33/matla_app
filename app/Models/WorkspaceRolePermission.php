<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class WorkspaceRolePermission extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'workspace_role_permissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'workspace_role_id',
        'workspace_permission_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
