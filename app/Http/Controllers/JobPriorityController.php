<?php

namespace App\Http\Controllers;

use App\JobPriority;
use App\Http\Requests\JobPriorityRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class JobPriorityController extends Controller
{
    public function index()
    {
        $priorities = JobPriority::all();
        return view('JobPriority.index', compact('priorities'));
    }

    public function create()
    {
        return view('JobPriority.create');
    }

    public function store(JobPriorityRequest $request)
    {
        JobPriority::create($request->validated());
        // dd($request->validated());
        return redirect()->route('jobPriorities.index')->with('success', 'Priority created successfully.');
    }

    public function show(JobPriority $jobPriority)
    {
        return view('JobPriority.show', compact('jobPriority'));
    }

    public function edit(JobPriority $jobPriority)
    {
        return view('JobPriority.create', compact('jobPriority'));
    }

    public function update(JobPriorityRequest $request, JobPriority $jobPriority)
    {
        $jobPriority->update($request->validated());
        return redirect()->route('jobPriorities.index')->with('success', 'Priority updated successfully.');
    }

    public function destroy(JobPriority $jobPriority)
    {
        // dump("testeado deleted: ");
        // dump($jobPriority);
        // Log::info("testeado deleted: ");
        // Log::info("$jobPriority");
        $jobPriority->update(['status' => 2]);
        return redirect()->route('jobPriorities.index')->with('success', 'Priority deleted successfully.');
    }

    public function activate(JobPriority $jobPriority)
    {
        $jobPriority->update(['status' => 1]);
        // dump('Intenta cambiar estado: ');
        // dump("$JobPriority"); // Volcar mensaje de éxito sin detener la ejecución 
        Log::info('Intenta cambiar estado'); // Guardar el mensaje en los logs
        Log::info("$jobPriority");
        return redirect()->route('jobPriorities.index')->with('success', 'Priority activated successfully.');
    }

    public function desactivate(JobPriority $jobPriority)
    {
        $jobPriority->update(['status' => 0]);
        return redirect()->route('jobPriorities.index')->with('success', 'Priority desactivated successfully.');
    }
}
