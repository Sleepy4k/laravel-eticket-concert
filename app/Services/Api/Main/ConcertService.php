<?php

namespace App\Services\Api\Main;

use App\Services\ApiService;
use App\Http\Resources\Main\ConcertResource;

class ConcertService extends ApiService
{
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $concerts = $this->concertInterface->all(['*'], ['company']);

        if (count($concerts) > 0) {
            return $this->createResponse(trans('api.response.accepted'), [
                'data' => ConcertResource::collection($concerts)
            ], 202);
        }

        return $this->createResponse(trans('api.response.accepted'), [
            'data' => trans('api.response.no_data')
        ], 202);
    }

    /**
     * Display the specified resource.
     * 
     * @param  string  $code
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        $concert = $this->concertInterface->all(['*'], ['company'], [['code', $code]])->first();

        if (empty($concert)) {
            return $this->createResponse(trans('api.response.not_found'), [
                'error' => trans('api.concert.not_found')
            ], 404);
        }

        return $this->createResponse(trans('api.response.accepted'), [
            'data' => new ConcertResource($concert)
        ], 206);
    }
}