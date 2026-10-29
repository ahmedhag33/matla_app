<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class ProgramTypes extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'program_types';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'description',
        'slug',
        'icon',
        'is_active',
    ];
    /**
     * Interact with the icon attribute.
     *
     * @return Attribute
     */
    public function iconAtFull(): Attribute
    {
        return Attribute::make(
            get: fn() => asset('public/img/' . $this->icon),
        );
    }
}
