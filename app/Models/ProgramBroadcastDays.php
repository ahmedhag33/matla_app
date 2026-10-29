<?php

namespace App\Models;

use App\Service\Enum\BroadcastDay;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class ProgramBroadcastDays extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'program_broadcast_days';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'program_id',
        'day',
    ];
    /**
     * Interact with the dayAt enum attribute.
     *
     * @return Attribute
     */
    public function dayAtFromEnum(): Attribute
    {
        return Attribute::make(
            get: fn() => match ($this->day) {
                BroadcastDay::Sunday->value => __('sunday'),
                BroadcastDay::Monday->value => __('monday'),
                BroadcastDay::Tuesday->value => __('tuesday'),
                BroadcastDay::Wednesday->value => __('wednesday'),
                BroadcastDay::Thursday->value => __('thursday'),
                BroadcastDay::Friday->value => __('friday'),
                BroadcastDay::Saturday->value => __('saturday'),
            },
        );
    }
}
