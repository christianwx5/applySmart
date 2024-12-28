<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index()
    {
        $companies = Company::all();
        return view('companies.index', compact('companies'));
    }

    public function create()
    {
        return view('companies.create');
    }

    public function store(Request $request)
    { 
        $request->validate([
            'name' => 'required|unique:companies|max:255',
            'country' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'importance' => 'required|integer|min:1|max:10',
        ]);

        Company::create([
            'name' => $request->name,
            'country' => $request->country,
            'type' => $request->type,
            'importance' => $request->importance,
        ]);

        return redirect()->route('companies.index')->with('success', 'Empresa registrada exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    public function edit(Company $company)
    {
        return view('companies.create', compact('company'));
    }
    
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required|unique:companies,name,' . $company->id . '|max:255',
            'country' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'importance' => 'required|integer|min:1|max:10',
        ]);
    
        $company->update($request->all());
    
        return redirect()->route('companies.index')->with('success', 'Empresa actualizada exitosamente');
    }

    public function destroy(Company $company)
    {
        $company->update(['status' => 2]);
        return redirect()->route('companies.index')->with('success', 'Empresa eliminada exitosamente');
    }
    
    public function activate(Company $company)
    {
        $company->update(['status' => 1]);
        return redirect()->route('companies.index')->with('success', 'Empresa activada exitosamente');
    }
    
    public function desactivate(Company $company)
    {
        $company->update(['status' => 0]);
        return redirect()->route('companies.index')->with('success', 'Empresa desactivada exitosamente');
    }
}


