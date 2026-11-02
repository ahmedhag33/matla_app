<?php

namespace Database\Seeders;

use App\Models\WorkspaceNotification;
use Illuminate\Database\Seeder;

class UpdateWorkspaceNotifcations extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notifications = WorkspaceNotification::all();
        // Update each notification with a unique code
        foreach ($notifications as $notification) {
            // Generate a unique code for the notification if it doesn't already have one
            if (!$notification->code) {
                $notification->code = uniqid();
            }
            $notification->save();
        }
    }
}
