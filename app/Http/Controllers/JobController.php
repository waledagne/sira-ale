<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View{
        $title = 'Jobs List';
        $jobs = ['Web Developer','Software Engineer','System Analyst','Database Administrator'];
        return view('jobs.index',compact('title','jobs'));
    }
    public function create(): View{
      return view('jobs.create');
    }

    public function store(Request $request): string{
        $title=$request->input('title');
        $desc = $request->input('desc');
        return "Title: $title, Description: $desc";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return "Showing job $id";
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
