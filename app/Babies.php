<?php

namespace App;

use App\Models\Baby;
use Illuminate\Http\Request;
use Illuminate\Http\Response;   
use Illuminate\Validation\ValidationException;
use App\Transformers\BabyTransformer;

class Babies
{
    /**
     * Get list of paginated babies.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getBabies(Request $request): array
    {
        $babies = Baby::all();

        return fractal($babies, new BabyTransformer())->toArray();
    }

    /**
     * Store a new baby.
     *
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeBaby(array $attrs): array
    {
        
        $baby = new Baby($attrs);

        if (!$baby->isValidFor('CREATE')) {
            throw new ValidationException($baby->validator());
        }
        if ($baby['birth_datetime']){
            $var = $baby['birth_datetime'];
            $date = str_replace('/', '-', $var);
            $baby['birth_datetime'] = date('Y-m-d H:i:s', strtotime($date));    
        }
        $baby->save();

        return fractal($baby, new BabyTransformer())->toArray();
    }

    /**
     * Get a baby by ID.
     *
     * @param  int  $id
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getBabyById(int $id): array
    {
        $baby = Baby::find($id);
        if (!$baby){
            return array("error" => [
                "message" => "baby with id ".$id." not found!",
                "status" =>  Response::HTTP_NOT_FOUND]);    
        }
        return fractal($baby, new BabyTransformer())->toArray();
    }

    /**
     * Update a baby by ID.
     *
     * @param  int  $id
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateBabyById(int $id, array $attrs): array
    {
        $baby = Baby::find($id);
        if ($baby){
            $baby->fill($attrs);

            if (!$baby->isValidFor('UPDATE')) {
                throw new ValidationException($baby->validator());
            }
            if ($baby['birth_datetime']){
                $var = $baby['birth_datetime'];
                $date = str_replace('/', '-', $var);
                $baby['birth_datetime'] = date('Y-m-d H:i:s', strtotime($date));    
            }
            $baby->save();

        }
        return fractal($baby, new BabyTransformer())->toArray();
    }

    /**
     * Delete a baby by ID.
     *
     * @param  int  $id
     * @return bool
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deleteBabyById(int $id): bool
    {
        $baby = Baby::find($id);
        if (!$baby){
            return false;    
        }
        return (bool) $baby->delete();
    }
}