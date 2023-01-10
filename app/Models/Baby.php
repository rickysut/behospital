<?php

namespace App\Models;

use Illuminate\Auth\Middleware\Authorize;

use Laravel\Lumen\Auth\Authorizable;
use App\Traits\AttributeHashable;
use App\Traits\ModelValidatable;
use App\Traits\QueryFilterable;
use Illuminate\Database\Eloquent\Model;
use App\Models\ParentInfo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Baby extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable, ModelValidatable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id', 
        'birth_age',
        'gender', 
        'size_long',
        'size_weight',
        'birth_datetime',
        'partus_type'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Validation rules for the model.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            '*' => [
                'parent_id'     => 'required|numeric',
                'birth_age'     => 'required|numeric',
                'gender'        => 'required|numeric',
                'size_long'     => 'required|numeric',
                'size_weight'   => 'required|numeric',
                'birth_datetime' => 'required|date_format:d/m/Y',
                'partus_type'   => 'required|numeric'
            ]
            
        ];
    }

    public function parentInfo()
    {
        return $this->belongsTo(ParentInfo::class, 'parent_id', 'id');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }
    
}
