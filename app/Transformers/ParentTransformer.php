<?php

namespace App\Transformers;

use App\Models\ParentInfo;
use League\Fractal\TransformerAbstract;

class ParentTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\ParentInfo  $parent
     * @return array
     */
    public function transform(ParentInfo $parent): array
    {
        return [
            'id' => (int) $parent->id,
            'mother_name' => (string) $parent->mather_name,
            'father_name' => (string) $parent->father_name,
            'mother_age' => (int) $parent->mother_age,
            'father_age' => (int) $parent->father_age,
            'address' => (string) $parent->address,
            'phone_number' => (string) $parent->phone_number,
        ];
    }
}


