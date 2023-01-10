<?php

namespace App;

use App\Models\ParentInfo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;   
use Illuminate\Validation\ValidationException;
use App\Transformers\ParentTransformer;

class Parents
{
    /**
     * Get list of paginated parents.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getParents(Request $request): array
    {
        $parents = ParentInfo::all();

        return fractal($parents, new ParentTransformer())->toArray();
    }

    /**
     * Store a new parent.
     *
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeParent(array $attrs): array
    {
        
        $parent = new ParentInfo($attrs);

        if (!$parent->isValidFor('CREATE')) {
            throw new ValidationException($parent->validator());
        }
        $parent->save();

        return fractal($parent, new ParentTransformer())->toArray();
    }

    /**
     * Get a parent by ID.
     *
     * @param  int  $id
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getParentById(int $id): array
    {
        $parent = ParentInfo::find($id);
        if (!$parent){
            return array("error" => [
                "message" => "parent with id ".$id." not found!",
                "status" =>  Response::HTTP_NOT_FOUND]);    
        }
        return fractal($parent, new ParentTransformer())->toArray();
    }

    /**
     * Update a parent by ID.
     *
     * @param  int  $id
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateParentById(int $id, array $attrs): array
    {
        $parent = ParentInfo::find($id);
        if ($parent){
            $parent->fill($attrs);

            if (!$parent->isValidFor('UPDATE')) {
                throw new ValidationException($parent->validator());
            }
            
            $parent->save();

        }
        return fractal($parent, new ParentTransformer())->toArray();
    }

    /**
     * Delete a parent by ID.
     *
     * @param  int  $id
     * @return bool
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deleteParentById(int $id): bool
    {
        $parent = ParentInfo::find($id);
        if (!$parent){
            return false;    
        }
        return (bool) $parent->delete();
    }
}