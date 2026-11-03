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
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['day_at_from_enum'];
    /**
     * Interact with the dayAt enum attribute.
     *
     * @return Attribute
     */
    public function dayAtFromEnum(): Attribute
    {
        return Attribute::make(
            get: fn() => match ($this->day) {
                BroadcastDay::SUNDAY->value => __('sunday'),
                BroadcastDay::MONDAY->value => __('monday'),
                BroadcastDay::TUESDAY->value => __('tuesday'),
                BroadcastDay::WEDNESDAY->value => __('wednesday'),
                BroadcastDay::THURSDAY->value => __('thursday'),
                BroadcastDay::FRIDAY->value => __('friday'),
                BroadcastDay::SATURDAY->value => __('saturday'),
            },
        );
    }
}
