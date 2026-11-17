<?php

namespace App\Helpers;

use App\Models\Program;

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
}
