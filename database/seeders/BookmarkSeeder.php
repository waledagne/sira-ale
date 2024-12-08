<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Job;
use App\Models\User;

class BookmarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // get test user
        $testUser = User::where('email','wale@gmail.com')->firstOrFail();
        $jobIds = Job::pluck('id')->toArray();
        $randomJobIds = array_rand($jobIds, 4);

        //attach selected jobs as bookmarks for test user
        foreach($randomJobIds as $jobId){
            $testUser->bookmarkedJobs()->attach($jobIds[$jobId]);
        }
    }
}
