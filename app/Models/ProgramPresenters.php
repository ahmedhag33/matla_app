<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramPresenters extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'program_presenters';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'program_id',
        'presenter_id',
    ];
}
