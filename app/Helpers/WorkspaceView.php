<?php

namespace App\Helpers;

use App\Models\Program;
use App\Models\Episode;

class WorkspaceView
{
    /**
     * Check if a program has episodes.
     *
     * @param int $program_id
     * @return bool
     */
    public static function check_episodes_in_program($program_id)
    {
        $program = Program::find($program_id);
        // Check if the program exists and has episodes
        return $program ? $program->episodes()->exists() : false;
    }
    /**
     * Check if an episode has segments.
     *
     * @param int $episode_id
     * @return bool
     */
    public static function check_segments_in_episode($episode_id)
    {
        $episode = Episode::find($episode_id);
        // Check if the episode exists and has segments
        return $episode ? $episode->segments()->exists() : false;
    }
}
