<?php

namespace App\Http\Controllers;

use App\Accounts;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Controller constructor.
     *
     * @param  \App\Accounts  $accounts
     */
    public function __construct(Accounts $accounts)
    {
        $this->accounts = $accounts;
    }

    /**
     * Get all the users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $users = $this->accounts->getUsers($request);

        return response()->json($users, Response::HTTP_OK);
    }

    /**
     * Store a user.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $user = $this->accounts->storeUser($request->all());

        return response()->json($user, Response::HTTP_CREATED);
    }

    /**
     * Get a user.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $user = $this->accounts->getUserById($id);

        return response()->json($user, Response::HTTP_OK);
    }

    /**
     * Update a user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $user = $this->accounts->updateUserById($id, $request->all());
        if ($user['data']){
            return response()->json($user, Response::HTTP_OK);
        }
        else 
            return response()->json(["message" => "User not found"], Response::HTTP_NOT_FOUND);

    }

    /**
     * Delete a user.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        if ($this->accounts->deleteUserById($id))
            return response()->json(["message" => "User deleted"], Response::HTTP_OK);
        else 
            return response()->json(["message" => "User not found"], Response::HTTP_NOT_FOUND);
    }
}
