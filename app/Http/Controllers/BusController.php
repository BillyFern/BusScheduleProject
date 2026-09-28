<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Http\Requests\StoreBusRequest;
use App\Http\Requests\UpdateBusRequest;
use App\Http\Resources\BusResource;

class BusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Bus::query();

        $sortField = request("sort_field", "created_at");
        $sortDirection  =request("sort_direction", "desc");

        if (request("kode_bus")){
            $query->where("kode_bus", "like", "%" . request("kode_bus"). "%");
        }

        $buses =$query->orderBy($sortField, $sortDirection)->paginate(10);
        return inertia("Bus/Index", [
            "buses" => BusResource::collection($buses),
            'queryParams' => request()->query() ?: null,
            'success' => session('success')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia("Bus/Create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBusRequest $request)
    {
        $data = $request->validated();
        /** @var $image \Illuminate\Http\UploadedFile */
        Bus::create($data);
        return to_route('bus.index')->with('success', 'Bus was created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bus $bus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $bus = Bus::find($id);
        return inertia('Bus/Edit', [
            'bus' => new BusResource($bus),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBusRequest $request, int $id)
    {
        $bus = Bus::find($id);
        $kode = $bus->kode_bus;
        $data = $request->validated();
        $bus->update($data);
        return to_route('bus.index')->with('success', "bus Kode \"$kode\" was updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $bus = Bus::find($id);
        $kode = $bus->kode_bus;
        $bus ->delete();
        return to_route('bus.index')
        ->with('success', "bus Kode \"$kode\" was deleted");
    }
}