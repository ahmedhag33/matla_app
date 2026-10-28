<?php

namespace App\Models\Querys;

use Illuminate\Database\Eloquent\Builder;

trait CanByMember
{
    /**
     * Scope a query to only include records that can be accessed by the current member
     *
     * @param  Builder $query
     * @return Builder
     */
    public function scopeCanByMember(Builder $query)
    {
        return $query->where('member_id', auth()->guard('member')->user()->id);
    }
}
