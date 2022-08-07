<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TimStoreRequest;
use App\Http\Requests\TimUpdateRequest;
use App\Http\Resources\TimResource;
use App\Models\Tim;
use Illuminate\Http\Request;

class TimController extends Controller
{

    public function index()
    {
        return (new TimResource(Tim::latest('created_at')->get()))->response()->setStatusCode(200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TimStoreRequest $request)
    {

        $data = $request->validated();
        $data['logo'] = $request->file('logo')->storeAs('public', str_replace(" ", "", $data['nama']) . $request->file('logo')->hashName());
        $tim = Tim::create($data);
        return (new TimResource($tim))->response()->setStatusCode(200);
    }

    public function show($id)
    {
        $tim = Tim::find($id);
        return (new TimResource($tim))->response()->setStatusCode(200);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TimUpdateRequest $request, $id)
    {
        $data = $request->validated();
        $tim = Tim::find($id);
        $tim->nama = $data['nama'];
        $tim->tahun = $data['tahun'];
        $tim->alamat = $data['alamat'];
        $tim->kota = $data['kota'];
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->storeAs('public', str_replace(" ", "", $data['nama']) . $request->file('logo')->hashName());
            $tim->logo = $data['logo'];
        }
        $tim->save();
        return (new TimResource($tim))->response()->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tim = Tim::find($id);
        $tim->delete();
        return (new TimResource($tim))->response()->setStatusCode(200);
    }
}
