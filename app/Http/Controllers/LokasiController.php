<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Http\Requests\StoreLokasiRequest;
use App\Http\Requests\UpdateLokasiRequest;
use App\Http\Resources\LokasiResource;

class LokasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Lokasi::query();

        $sortField = request("sort_field", "created_at");
        $sortDirection  =request("sort_direction", "desc");

        if (request("nama_lokasi")){
            $query->where("nama_lokasi", "like", "%" . request("nama_lokasi"). "%");
        }

        $lokasis =$query->orderBy($sortField, $sortDirection)->paginate(10);
        return inertia("Lokasi/Index", [
            "lokasis" => LokasiResource::collection($lokasis),
            'queryParams' => request()->query() ?: null,
            'success' => session('success'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia("Lokasi/Create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLokasiRequest $request)
    {
        $data = $request->validated();
        /** @var $image \Illuminate\Http\UploadedFile */
        Lokasi::create($data);
        return to_route('lokasi.index')->with('success', 'Lokasi baru telah ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lokasi $lokasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lokasi $lokasi)
    {
        return inertia('Lokasi/Edit', [
            'lokasi' => new LokasiResource($lokasi),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLokasiRequest $request, Lokasi $lokasi)
    {
        $nama = $lokasi->nama_lokasi;
        $data = $request->validated();
        $lokasi->update($data);
        return to_route('lokasi.index')->with('success', "Lokasi \"$nama\" was updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lokasi $lokasi)
    {
        $nama = $lokasi->nama_lokasi;
        $lokasi ->delete();
        return to_route('lokasi.index')
        ->with('success', "Lokasi \"$nama\" was deleted");
    }
}
