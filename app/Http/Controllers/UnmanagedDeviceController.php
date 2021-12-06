<?php

namespace App\Http\Controllers;

use App\Models\unmanagedDevice;
use Illuminate\Http\Request;

class UnmanagedDeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "UnmanagedDevices";
        $items = unmanagedDevice::all();
        return view('unmanagedDevice.index')->with([
            'title' =>  $title,
            'items' => $items,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\unmanagedDevice  $unmanagedDevice
     * @return \Illuminate\Http\Response
     */
    public function show(unmanagedDevice $unmanagedDevice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\unmanagedDevice  $unmanagedDevice
     * @return \Illuminate\Http\Response
     */
    public function edit(unmanagedDevice $unmanagedDevice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\unmanagedDevice  $unmanagedDevice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, unmanagedDevice $unmanagedDevice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\unmanagedDevice  $unmanagedDevice
     * @return \Illuminate\Http\Response
     */
    public function destroy(unmanagedDevice $unmanagedDevice)
    {
        //
    }
}
