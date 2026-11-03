<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function index()
    {
        $statuses = Status::paginate(10);
        return view('master-data.status.index', compact('statuses'));
    }

    public function create()
    {
        return view('master-data.status.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_status' => 'required|string|max:50|unique:statuses',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        Status::create($validated);
        return redirect()->route('status.index')->with('success', 'Status berhasil ditambahkan');
    }

    public function show(Status $status)
    {
        return view('master-data.status.show', compact('status'));
    }

    public function edit(Status $status)
    {
        return view('master-data.status.edit', compact('status'));
    }

    public function update(Request $request, Status $status)
    {
        $validated = $request->validate([
            'nama_status' => 'required|string|max:50|unique:statuses,nama_status,' . $status->id,
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $status->update($validated);
        return redirect()->route('status.index')->with('success', 'Status berhasil diperbarui');
    }

    public function destroy(Status $status)
    {
        $status->delete();
        return redirect()->route('status.index')->with('success', 'Status berhasil dihapus');
    }
}
