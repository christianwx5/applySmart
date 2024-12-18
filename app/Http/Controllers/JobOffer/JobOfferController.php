<?php

namespace App\Http\Controllers\JobOffer;

use App\Http\Controllers\Controller;
use App\JobOffer;
use Illuminate\Http\Request;

class JobOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobOffers = JobOffer::latest()->get();
        return view('JobOffer.list', compact('jobOffers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('JobOffer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // dd($request->all());
        //print_r($request->input('idApplyStatus'), false);
        
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'title' => 'required|string|max:30',
            'description' => 'required|string',
            'Company' => 'required|string|max:50',
            'idPriority' => 'required|int',
        ]);

        // dd($request->request);

        // Crear una nueva oferta de trabajo
        $jobOffer = JobOffer::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'Company' => $validatedData['Company'],
            'idApplyStatus' => $request->input('idApplyStatus'),
            'idPriority' => $validatedData['idPriority'],
        ]);

        // Redirigir a la página de listado de ofertas de trabajo con un mensaje de éxito
        return back()->with('success', 'Job offer created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\JobOffert  $jobOffert
     * @return \Illuminate\Http\Response
     */
    public function show(JobOffer $jobOffer)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\JobOffert  $jobOffert
     * @return \Illuminate\Http\Response
     */
    public function edit(JobOffer $JobOffer) {

         // dd($JobOffer);
        return view('JobOffer.create', compact('JobOffer'));
    }     

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\JobOffert  $jobOffert
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobOffer $jobOffer) { 
        // Validar y actualizar los datos 
        $validatedData = $request->validate([ 'title' => 'required|string|max:30', 'description' => 'required|string', 'Company' => 'required|string|max:50', 'idApplyStatus' => 'required|int', 'idPriority' => 'required|int', ]); 
        $jobOffer->update($validatedData);
         return redirect()->route('JobOffers.index')->with('success', 'Job offer updated successfully!'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\JobOffert  $jobOffert
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobOffer $jobOffert)
    {
        //
    }
}
