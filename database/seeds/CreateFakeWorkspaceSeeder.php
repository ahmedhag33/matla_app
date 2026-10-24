<?php

namespace Database\Seeders;

use App\Models\Workspace;
use Illuminate\Database\Seeder;

class CreateFakeWorkspaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Workspace::create([
            'name' => 'Fake Workspace',
            'slug' => 'fake-workspace',
            'description' => 'This is a fake workspace for testing purposes.',
            'created_by' => 14, // Assuming the user ID of the creator is 1
            'workspace_type_id' => 10,
            'country_id' => 1, // Assuming the country ID is 1
        ]);
    }
}
