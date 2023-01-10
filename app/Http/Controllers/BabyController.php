<?php

namespace App\Http\Controllers;

use App\Babies;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BabyController extends Controller
{
    /**
     * Controller constructor.
     *
     * @param  \App\Babies  $accounts
     */
    public function __construct(Babies $babies)
    {
        $this->babies = $babies;
    }

    /**
     * Get all the babies.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResponse
    {
        $babies = $this->babies->getBabies($request);

        return response()->json($babies, Response::HTTP_OK);
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
     * Store a baby.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $babies = $this->babies->storeBaby($request->all());

        return response()->json($babies, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Birth  $birth
     * @return \Illuminate\Http\Response
     */
    public function show(Birth $birth)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Birth  $birth
     * @return \Illuminate\Http\Response
     */
    public function edit(Birth $birth)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Birth  $birth
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Birth $birth)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Birth  $birth
     * @return \Illuminate\Http\Response
     */
    public function destroy(Birth $birth)
    {
        //
    }
}
