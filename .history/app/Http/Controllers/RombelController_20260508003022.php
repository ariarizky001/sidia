<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RombelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('rombel.index', [
            'title' => 'Data Rombel'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('rombel.create', [
            'title' => 'Tambah Rombel'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // TODO: Implementasi penyimpanan data
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // TODO: Implementasi menampilkan detail
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // TODO: Implementasi edit form
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // TODO: Implementasi update data
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // TODO: Implementasi hapus data
    }
}
