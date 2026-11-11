<?php

namespace App\Providers;

use App\Models\ProgramBroadcastDays;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Validator::extend('episode_scheduled_on_program_day', function ($attribute, $value, $parameters, $validator) {
            $programId = $validator->getData()['check_program_id'] ?? null;
            // If program ID is not provided, validation fails
            if (!$programId) {
                return false;
            }
            $date = convertArabicDateToDatabase($value);
            // Extract the day of the week from the converted date
            $day = strtolower(Carbon::parse($date)->format('l'));
            // Check if the episode's scheduled day is in the program's broadcast days
            return ProgramBroadcastDays::where('program_id', $programId)
                ->where('day', $day)
                ->exists();
        });
    }
}
