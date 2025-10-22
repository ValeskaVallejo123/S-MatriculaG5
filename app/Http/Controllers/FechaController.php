<?php

namespace App\Http\Controllers;

use App\Models\Fecha;
use Illuminate\Http\Request;

class FechaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        // Evento::create($request->all());
    return redirect()->back()->with('success', 'Evento guardado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Fecha $fecha)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fecha $fecha)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fecha $fecha)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fecha $fecha)
    {
        //
    }
}