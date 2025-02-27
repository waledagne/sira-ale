<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Job;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
class JobController extends Controller
{

  use AuthorizesRequests;

  public function index(): View
  {
    $jobs = Job::latest()->paginate(10);
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

    $validatedData['user_id'] = auth()->user()->id;

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
    $this->authorize('update', $job);
    return view('jobs.edit')->with('job', $job);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Job $job)
  {
    $this->authorize('update', $job);
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
    $this->authorize('delete', $job);
    if ($job->company_logo) {
      Storage::delete('public/logos' . basename($job->company_logo));
    }
    $job->delete();
    if(request()->query('from') == 'dashboard'){
    return redirect()->route('dashboard')->with('success', 'Job deleted successfully');

    }
    return redirect()->route('jobs.index')->with('success', 'Job deleted successfully');
  }

  public function search(Request $request)
{
    $keywords = strtolower($request->input('keywords'));
    $location = strtolower($request->input('location'));

    $query = Job::query();

    if ($keywords) {
        $query->where(function ($q) use ($keywords) {
            $q->whereRaw('LOWER(title) like ?', ['%' . $keywords . '%'])
                ->orWhereRaw('LOWER(description) like ?', ['%' . $keywords . '%']);
        });
    }

    if ($location) {
        $query->where(function ($q) use ($location) {
            $q->whereRaw('LOWER(address) like ?', ['%' . $location . '%'])
                ->orWhereRaw('LOWER(city) like ?', ['%' . $location . '%'])
                ->orWhereRaw('LOWER(state) like ?', ['%' . $location . '%'])
                ->orWhereRaw('LOWER(zipcode) like ?', ['%' . $location . '%']);
        });
    }

    $jobs = $query->paginate(10);

    return view('jobs.index')->with('jobs', $jobs);
}
}
