<?php

namespace App\Http\Controllers;

use App\Models\Keberangkatan;
use App\Models\Kedatangan;
use App\Http\Requests\StoreKeberangkatanRequest;
use App\Http\Requests\UpdateKeberangkatanRequest;
use App\Http\Resources\KeberangkatanResource;
use App\Http\Resources\KedatanganResource;

class PapanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Keberangkatan::query();

        $jadwals = $query->orderBy('status', 'asc')
            ->orderBy('waktu_keberangkatan', 'asc')->paginate(20);

        return inertia("PapanKeberangkatan", [
            "jadwals" => KeberangkatanResource::collection($jadwals),
        ]);
    }

    public function kedatangan()
    {
        $query = Kedatangan::query();

        $jadwals = $query->orderBy('status', 'asc')
            ->orderBy('waktu_kedatangan', 'asc')->paginate(20);

        return inertia("PapanKedatangan", [
            "jadwals" => KedatanganResource::collection($jadwals),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKeberangkatanRequest $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(Keberangkatan $jadwal)
    {
        // $query = $jadwal->buses();
        // $sortField = request("sort_field", "created_at");
        // $sortDirection  =request("sort_direction", "desc");

        // if (request("name")){
        //     $query->where("name", "like", "%" . request("name"). "%");
        // }
        // if (request("status")){
        //     $query->where("status", request("status"));
        // }
        // $buses = $query->orderBy($sortField, $sortDirection)->paginate(10);

        // return inertia('Keberangkatan/Show',[
        //     'jadwal' => new KeberangkatanResource($jadwal),
        //     "buses" => BusResource::collection($buses),
        //     'queryParams' => request()->query() ?: null,
        //     'success'=>session('success'),
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Keberangkatan $jadwal)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKeberangkatanRequest $request, Keberangkatan $jadwal)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Keberangkatan $jadwal)
    {
    }
}
