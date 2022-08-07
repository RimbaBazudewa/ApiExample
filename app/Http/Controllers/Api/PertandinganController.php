<?php

namespace App\Http\Controllers\Api;

use App\Models\Pertandingan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PertandinganStoreRequest;
use App\Http\Resources\PertandinganResource;
use Exception;

class PertandinganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return (new PertandinganResource(Pertandingan::with('homeTim', 'awayTim', 'detailPertandingans')->latest('tanggal')->get()))->response()->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PertandinganStoreRequest $request)
    {
        $data = $request->validated();
        try {
            $pertandingan = Pertandingan::create($data);
            return (new PertandinganResource($pertandingan))->response()->setStatusCode(200);
        } catch (Exception $e) {
            return response()->json(['error' => 'menyimpan data pertadingan gagal terdapat error :' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pertandingan  $pertandingan
     * @return \Illuminate\Http\Response
     */
    public function show(Pertandingan $pertandingan)
    {
        return (new PertandinganResource($pertandingan))->response()->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pertandingan  $pertandingan
     * @return \Illuminate\Http\Response
     */
    public function update(PertandinganStoreRequest $request, Pertandingan $pertandingan)
    {
        $data = $request->validated();
        try {
            $pertandingan->update($data);
            return (new PertandinganResource($pertandingan))->response()->setStatusCode(200);
        } catch (Exception $e) {
            return response()->json(['error' => 'meperbaharui data pertadingan gagal terdapat error : ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pertandingan  $pertandingan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pertandingan $pertandingan)
    {
        try {
            $pertandingan->delete();
            return (new PertandinganResource($pertandingan))->response()->setStatusCode(200);
        } catch (Exception $e) {
            return response()->json(['error' => 'menghapus data pertadingan gagal terdapat error : ' . $e->getMessage()], 500);
        }
    }
}
