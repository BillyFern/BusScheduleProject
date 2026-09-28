<?php

namespace App\Http\Controllers;

use App\Models\Keberangkatan;
use App\Models\Bus;
use App\Models\Lokasi;
use App\Http\Requests\StoreKeberangkatanRequest;
use App\Http\Requests\UpdateKeberangkatanRequest;
use App\Http\Resources\KeberangkatanResource;
use App\Http\Resources\BusResource;
use App\Http\Resources\LokasiResource;

class KeberangkatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Keberangkatan::query();

        $sortField = request("sort_field", "created_at");
        $sortDirection  =request("sort_direction", "desc");
        $keberangkatans =$query->orderBy($sortField, $sortDirection)->paginate(10);

        return inertia("Keberangkatan/Index", [
            "keberangkatans" => KeberangkatanResource::collection($keberangkatans),
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
        return inertia("Keberangkatan/Create", [
            'buses' => $bus,
            'lokasis' => $lokasi,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKeberangkatanRequest $request)
    {
        $data = $request->validated();
        print_r($data);

        /** @var $image \Illuminate\Http\UploadedFile */
        Keberangkatan::create($data);
        return to_route('keberangkatan.index')
            ->with('success', 'Keberangkatan was created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Keberangkatan $keberangkatan)
    {
        // $query = $keberangkatan->buses();
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
        //     'keberangkatan' => new KeberangkatanResource($keberangkatan),
        //     "buses" => BusResource::collection($buses),
        //     'queryParams' => request()->query() ?: null,
        //     'success'=>session('success'),
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Keberangkatan $keberangkatan)
    {
        $bus = Bus::all();
        $lokasi = Lokasi::all();
        return inertia('Keberangkatan/Edit', [
            'keberangkatan' => new KeberangkatanResource($keberangkatan),
            'buses' => $bus,
            'lokasis' => $lokasi
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKeberangkatanRequest $request, Keberangkatan $keberangkatan)
    {
        $kode = $keberangkatan->id;
        $data = $request->validated();
        $keberangkatan->update($data);
        return to_route('keberangkatan.index')
        ->with('success', "Keberangkatan Kode \"$kode\" was updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Keberangkatan $keberangkatan)
    {
        $kode = $keberangkatan->id;
        $keberangkatan ->delete();
        return to_route('keberangkatan.index')
        ->with('success', "Keberangkatan Kode \"$kode\" was deleted");

    }

    public function resetStatus()
    {
        $keberangkatans = Keberangkatan::all();

        foreach($keberangkatans as $keberangkatan){
            $keberangkatan->status = 2;
            $keberangkatan->save();
        }
        return to_route('keberangkatan.index')
        ->with('success', "Status keberangkatan telah di reset");
    }
}