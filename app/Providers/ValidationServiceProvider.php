<?php

namespace App\Providers;

use App\Models\Episode;
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
        // Validate that the episode is scheduled on a program day
        Validator::extend('episode_scheduled_in_future', function ($attribute, $value, $parameters, $validator) {
            $date = Carbon::parse(convertArabicDateToDatabase($value));
            // Check if the episode's scheduled date is today or in the future
            return $date->greaterThanOrEqualTo(today());
        });
        // Validate that the segment duration is positive
        Validator::extend('segment_duration_positive', function ($attribute, $value, $parameters, $validator) {
            return $value > 0;
        });
        // Validate that the segment duration is less than the episode duration
        Validator::extend('segment_less_then_episode_duration', function ($attribute, $value, $parameters, $validator) {
            $episodeId = $validator->getData()['episode_id'] ?? null;
            // If episode ID is not provided, validation fails
            if (!$episodeId) {
                return false;
            }
            // Fetch the episode from the database
            $episode = Episode::find($episodeId);
            // If the episode is not found, validation fails
            if (!$episode) {
                return false;
            }
            // Check if the segment duration is less than the episode duration
            return $value < $episode->duration;
        });
        // Validate that the total duration of all segments for an episode is less than the episode duration
        Validator::extend('total_segment_duration_less_than_episode', function ($attribute, $value, $parameters, $validator) {
            $episodeId = $validator->getData()['episode_id'] ?? null;
            // If episode ID is not provided, validation fails
            if (!$episodeId) {
                return false;
            }
            // Fetch the episode from the database
            $episode = Episode::find($episodeId);
            // If the episode is not found, validation fails
            if (!$episode) {
                return false;
            }
            $episodeDuration = $episode->duration;
            // Calculate the total duration of existing segments for the episode
            $totalSegmentDuration = $episode->segments()->sum('duration');
            // Check if adding the new segment exceeds the episode duration
            return ($totalSegmentDuration + $value) < $episodeDuration;
        });
    }
}
