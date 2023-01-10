<?php

namespace App\Transformers;

use App\Models\Baby;
use League\Fractal\TransformerAbstract;

class BabyTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\Baby  $baby
     * @return array
     */
    public function transform(Baby $baby): array
    {
        return [
            'id' => (int) $baby->id,
            'parent_id' => (int) $baby->parent_id,
            'gender' => (int) $baby->gender,
            'size_long' => (int) $baby->size_long,
            'size_weight' => (int) $baby->size_weight,
            'birth_datetime' => (string) $baby->birth_datetime,
            'partus_type' => (int) $baby->partus_type,
        ];
    }
}


