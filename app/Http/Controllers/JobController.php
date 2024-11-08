<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Job;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class JobController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(): View
  {
    $jobs = Job::all();
    return view('jobs.index', compact('jobs'));
  }
  public function create(): View
  {
    return view('jobs.create');
  }

  public function store(Request $request): RedirectResponse
  {
    $validatedData = $request->validate([
      'title' => 'required|string|max:255',
      'description' => 'required|string',
      'salary' => 'required|integer',
      'tags' => 'nullable|string',
      'job_type' => 'required|string',
      'remote' => 'required|boolean',
      'company_name' => 'required|string',
      'company_description' => 'required|string',
      'company_website' => 'nullable|url',
      'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      'contact_email' => 'required|string',
      'contact_phone' => 'required|string',
      'address' => 'nullable|string',
      'city' => 'required|string',
      'state' => 'required|string',
      'zipcode' => 'nullable|string',
      'requirements' => 'nullable|string',
      'benefits' => 'nullable|string',
    ]);

    //hardcoded user id
    $validatedData['user_id'] = 1;

    if ($request->hasFile('company_logo')) {
      $path = $request->file('company_logo')->store('logos', 'public');

      $validatedData['company_logo'] = $path;
    }
    Job::create($validatedData);
    return redirect()->route('jobs.index')->with('success', 'Job created successfully');
  }

  /**
   * Display the specified resource.
   */
  public function show(Job $job): View
  {
    return view('jobs.show')->with('job', $job);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Job $job): View
  {
    return view('jobs.edit')->with('job', $job);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Job $job)
  {
    $validatedData = $request->validate([
      'title' => 'required|string|max:255',
      'description' => 'required|string',
      'salary' => 'required|integer',
      'tags' => 'nullable|string',
      'job_type' => 'required|string',
      'remote' => 'required|boolean',
      'company_name' => 'required|string',
      'company_description' => 'required|string',
      'company_website' => 'nullable|url',
      'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      'contact_email' => 'required|string',
      'contact_phone' => 'required|string',
      'address' => 'nullable|string',
      'city' => 'required|string',
      'state' => 'required|string',
      'zipcode' => 'nullable|string',
      'requirements' => 'nullable|string',
      'benefits' => 'nullable|string',
    ]);


    if ($request->hasFile('company_logo')) {

      Storage::delete('public/logos' . basename($job->company_logo));

      $path = $request->file('company_logo')->store('logos', 'public');

      $validatedData['company_logo'] = $path;
    }
    $job->update($validatedData);
    return redirect()->route('jobs.index')->with('success', 'Job updated successfully');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Job $job)
  {
    if ($job->company_logo) {
      Storage::delete('public/logos' . basename($job->company_logo));
    }
    $job->delete();
    return redirect()->route('jobs.index')->with('success', 'Job deleted successfully');
  }
}
