<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'roles';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'code',
        'name',
        'slug',
        'description',
        'guard',
        'is_active',
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
        // create a slug from the name when creating a new role
        static::creating(function ($role) {
            $role->slug = str()->slug($role->name);
            // set the code to a random string if not provided
            $role->code = strtoupper($role->code);
        });
    }
    /**
     * Get the admins that belong to the role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function admins()
    {
        return $this->hasMany(Admin::class, 'role_id');
    }
}
