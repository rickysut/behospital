<?php

namespace App\Http\Controllers;

use App\Babies;
use App\Models\ParentInfo;
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
     * Store a baby.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        if ($request->string('parent_id')){
            $parentid = $request->string('parent_id');
            $parent = ParentInfo::find($parentid);
            if (!$parent) {
                return response()->json(['error' => 'parent_id not found!'], Response::HTTP_NOT_FOUND);  
            }
        }
        $babies = $this->babies->storeBaby($request->all());

        return response()->json($babies, Response::HTTP_CREATED);
    }

    /** 
    * Get a baby.
    *
    * @param  int  $id
    *
    * @return \Illuminate\Http\JsonResponse
    **/
   public function show(int $id): JsonResponse
   {
       $baby = $this->babies->getBabyById($id);

       return response()->json($baby, Response::HTTP_OK);
   }


    /**
     * Update the specified baby.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $baby = $this->babies->updateBabyById($id, $request->all());
        if ($baby['data']){
            return response()->json($baby, Response::HTTP_OK);
        }
        else 
            return response()->json(["message" => "Baby not found"], Response::HTTP_NOT_FOUND);
    }

    /**
     * Delete a baby.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        if ($this->babies->deleteBabyById($id))
            return response()->json(["message" => "Baby deleted"], Response::HTTP_OK);
        else 
            return response()->json(["message" => "Baby not found"], Response::HTTP_NOT_FOUND);
    }
}
