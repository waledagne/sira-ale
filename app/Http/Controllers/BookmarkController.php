<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class BookmarkController extends Controller
{
    public function index(): View{
        $user = Auth::user();
        $bookmarks = $user->bookmarkedJobs()->orderBy('job_user_bookmarks.created_at','desc')->paginate(10);
        return view('jobs.bookmarked')->with('bookmarks',$bookmarks);
    }

    public function store(Job $job): RedirectResponse{
        $user = Auth::user();

        if($user->bookmarkedJobs()->where('job_id',$job->id)->exists()) {
            return back()->with('error','Job already bookmarked');
        }

            // Create a new bookmark
        $user->bookmarkedJobs()->attach($job->id);

        return back()->with('status', 'Job bookmarked successfully.');

    }

    public function destroy(Job $job): RedirectResponse{
        $user = Auth::user();

        if(!$user->bookmarkedJobs()->where('job_id',$job->id)->exists()){
                return back()->with('error','Job not bookmarked');
        }

        $user->bookmarkedJobs()->detach($job->id);
        return back()->with('success','Bookmark removed');

    }
}
