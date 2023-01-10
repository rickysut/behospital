<?php

namespace App;

use App\Models\Baby;
use Illuminate\Http\Request;
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

        $baby->save();

        // event(new BabyCreated($baby));

        return fractal($baby, new BabyTransformer())->toArray();
    }
}