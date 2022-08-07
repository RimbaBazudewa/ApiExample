<?php

namespace App\Http\Controllers\Api;

use App\Models\DetailPertandingan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DetailPertandinganRequest;
use App\Http\Resources\DetailPertandinganResource;
use App\Models\Pemain;
use App\Models\Pertandingan;
use Exception;

class DetailPertandinganController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DetailPertandinganRequest $request)
    {

        $data = $request->validated();
        try {
            if (!$this->checkPemain($data['pemain_id'], $data['pertandingan_id'])) {
                return response()->json(['error' => 'pemain yang anda masukan tidak ada pada tim yang bertanding'], 200);
            }
            $detailPertandingan = DetailPertandingan::create($data);
            return (new DetailPertandinganResource($detailPertandingan))->response()->setStatusCode(200);
        } catch (Exception $e) {

            return response()->json(['error' => 'menyimpan data detail pertandigan gagal dengan error : ', $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DetailPertandingan  $detailPertandingan
     * @return \Illuminate\Http\Response
     */
    public function update(DetailPertandinganRequest $request, DetailPertandingan $detailPertandingan)
    {
        $data = $request->validated();
        try {
            if (!$this->checkPemain($data['pemain_id'], $data['pertandingan_id'])) {
                return response()->json(['error' => 'pemain yang anda masukan tidak ada pada tim yang bertanding '], 200);
            }
            $detailPertandingan->update($data);
            return (new DetailPertandinganResource($detailPertandingan))->response()->setStatusCode(200);
        } catch (Exception $e) {

            return response()->json(['error' => 'memperbaharui data detail pertandigan gagal dengan error : ', $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DetailPertandingan  $detailPertandingan
     * @return \Illuminate\Http\Response
     */
    public function destroy(DetailPertandingan $detailPertandingan)
    {
        try {
            $detailPertandingan->delete();
            return (new DetailPertandinganResource($detailPertandingan))->response()->setStatusCode(200);
        } catch (Exception $e) {

            return response()->json(['error' => 'Menghapus data detail pertandigan gagal dengan error : ', $e->getMessage()]);
        }
    }
    private function checkPemain($pemain_id, $pertandingan_id)
    {
        return (Pertandingan::whereHas('homeTim', function ($q) use ($pemain_id) {
            $q->whereHas('pemains', function ($k) use ($pemain_id) {
                $k->where('id', $pemain_id);
            });
        })->orWhereHas('awayTim', function ($q) use ($pemain_id) {
            $q->whereHas('pemains', function ($k) use ($pemain_id) {
                $k->where('id', $pemain_id);
            });
        })->where('id', $pertandingan_id)->first()) ? true : false;
    }
}
