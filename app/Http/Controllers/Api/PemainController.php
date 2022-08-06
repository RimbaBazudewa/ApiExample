<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PemainStoreRequest;
use App\Http\Requests\PemainUpdateRequest;
use App\Http\Resources\PemainResource;
use App\Models\Pemain;
use Exception;
use Illuminate\Http\Request;

class PemainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(PemainStoreRequest $request)
    {
        $data =   $request->validated();
        try {
            $pemain = Pemain::create($data);
            return (new PemainResource($pemain))->response()->setStatusCode(200);
        } catch (Exception $e) {
            return response()->json(["error" => 'terjadi kesalah dalam sistem dengan error ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PemainUpdateRequest $request, $id)
    {
        $data =   $request->validated();
        try {
            $pemain = Pemain::find($id);
            $pemain->update($data);
            return (new PemainResource($pemain))->response()->setStatusCode(200);
        } catch (Exception $e) {
            return response()->json(["error" => 'terjadi kesalah dalam sistem dengan error ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $pemain = Pemain::find($id);
            $pemain->delete();
            return (new PemainResource($pemain))->response()->setStatusCode(200);
        } catch (Exception $e) {
            return response()->json(["error" => 'terjadi kesalah dalam sistem dengan error ' . $e->getMessage()], 500);
        }
    }
}
