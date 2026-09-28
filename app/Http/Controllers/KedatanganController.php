<?php

namespace App\Http\Controllers;

use App\Models\Kedatangan;
use App\Models\Bus;
use App\Models\Lokasi;
use App\Http\Requests\StoreKedatanganRequest;
use App\Http\Requests\UpdateKedatanganRequest;
use App\Http\Resources\KedatanganResource;

class KedatanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Kedatangan::query();

        $sortField = request("sort_field", "created_at");
        $sortDirection  =request("sort_direction", "desc");
        $kedatangans =$query->orderBy($sortField, $sortDirection)->paginate(10);

        return inertia("Kedatangan/Index", [
            "kedatangans" => KedatanganResource::collection($kedatangans),
            'queryParams' => request()->query() ?: null,
            'success' => session('success'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bus = Bus::all();
        $lokasi = Lokasi::all();
        return inertia("Kedatangan/Create", [
            'buses' => $bus,
            'lokasis' => $lokasi,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKedatanganRequest $request)
    {
        $data = $request->validated();
        print_r($data);

        /** @var $image \Illuminate\Http\UploadedFile */
        Kedatangan::create($data);
        return to_route('kedatangan.index')
            ->with('success', 'Kedatangan was created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kedatangan $kedatangan)
    {
        // $query = $kedatangan->buses();
        // $sortField = request("sort_field", "created_at");
        // $sortDirection  =request("sort_direction", "desc");

        // if (request("name")){
        //     $query->where("name", "like", "%" . request("name"). "%");
        // }
        // if (request("status")){
        //     $query->where("status", request("status"));
        // }
        // $buses = $query->orderBy($sortField, $sortDirection)->paginate(10);

        // return inertia('Kedatangan/Show',[
        //     'kedatangan' => new KedatanganResource($kedatangan),
        //     "buses" => BusResource::collection($buses),
        //     'queryParams' => request()->query() ?: null,
        //     'success'=>session('success'),
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kedatangan $kedatangan)
    {
        $bus = Bus::all();
        $lokasi = Lokasi::all();
        return inertia('Kedatangan/Edit', [
            'kedatangan' => new KedatanganResource($kedatangan),
            'buses' => $bus,
            'lokasis' => $lokasi
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKedatanganRequest $request, Kedatangan $kedatangan)
    {
        $kode = $kedatangan->id;
        $data = $request->validated();
        $kedatangan->update($data);
        return to_route('kedatangan.index')
        ->with('success', "Kedatangan Kode \"$kode\" was updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kedatangan $kedatangan)
    {
        $kode = $kedatangan->id;
        $kedatangan ->delete();
        return to_route('kedatangan.index')
        ->with('success', "Kedatangan Kode \"$kode\" was deleted");

    }

    public function resetStatus()
    {
        $kedatangans = Kedatangan::all();

        dd($kedatangans);
        foreach($kedatangans as $kedatangan){
            $kedatangan->status = 2;
            $kedatangan->save();
        }
        return to_route('kedatangan.index')
        ->with('success', "Status kedatangan telah di reset");
    }
}