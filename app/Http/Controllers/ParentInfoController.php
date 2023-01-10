<?php

namespace App\Http\Controllers;

use App\Parents;
use App\Models\ParentInfo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ParentInfoController extends Controller
{
    /**
     * Controller constructor.
     *
     * @param  \App\Parents  $accounts
     */
    public function __construct(Parents $parents)
    {
        $this->parents = $parents;
    }

    /**
     * Get all the parents.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResponse
    {
        $parents = $this->parents->getParents($request);

        return response()->json($parents, Response::HTTP_OK);
    }

    /**
     * Store a parent.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $parent = $this->parents->storeParent($request->all());

        return response()->json($parent, Response::HTTP_CREATED);
    }

    /** 
    * Get a parent.
    *
    * @param  int  $id
    *
    * @return \Illuminate\Http\JsonResponse
    **/
   public function show(int $id): JsonResponse
   {
       $parent = $this->parents->getParentById($id);

       return response()->json($parent, Response::HTTP_OK);
   }


    /**
     * Update the specified parent.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $parent = $this->parents->updateParentById($id, $request->all());
        if ($parent['data']){
            return response()->json($parent, Response::HTTP_OK);
        }
        else 
            return response()->json(["message" => "Parent not found"], Response::HTTP_NOT_FOUND);
    }

    /**
     * Delete a parent.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        if ($this->parents->deleteParentById($id))
            return response()->json(["message" => "Parent deleted"], Response::HTTP_OK);
        else 
            return response()->json(["message" => "Parent not found"], Response::HTTP_NOT_FOUND);
    }
}
