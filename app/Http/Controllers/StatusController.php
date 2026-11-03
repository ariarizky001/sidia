<?php

namespace App\Http\Controllers;

use App\Models\StatusAsn;
use Illuminate\Http\Request;

class StatusAsnController extends Controller
{
    public function index()
    {
        $statusAsns = StatusAsn::paginate(10);
        return view('master-data.status-asn.index', compact('statusAsns'));
    }

    public function create()
    {
        return view('master-data.status-asn.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_status' => 'required|string|max:50|unique:status_asns',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        StatusAsn::create($validated);
        return redirect()->route('status-asn.index')->with('success', 'Status ASN berhasil ditambahkan');
    }

    public function show(StatusAsn $statusAsn)
    {
        return view('master-data.status-asn.show', compact('statusAsn'));
    }

    public function edit(StatusAsn $statusAsn)
    {
        return view('master-data.status-asn.edit', compact('statusAsn'));
    }

    public function update(Request $request, StatusAsn $statusAsn)
    {
        $validated = $request->validate([
            'nama_status' => 'required|string|max:50|unique:status_asns,nama_status,' . $statusAsn->id,
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $statusAsn->update($validated);
        return redirect()->route('status-asn.index')->with('success', 'Status ASN berhasil diperbarui');
    }

    public function destroy(StatusAsn $statusAsn)
    {
        $statusAsn->delete();
        return redirect()->route('status-asn.index')->with('success', 'Status ASN berhasil dihapus');
    }
}
