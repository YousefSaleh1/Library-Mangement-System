<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $data = new UserResource($user);
        return $this->customeResponse($data, 'Done!', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->name = $request->input('name') ?? $user->name;
        $user->email = $request->input('email') ?? $user->email;

        $user->save();
        $data = new UserResource($user);
        return $this->customeResponse($data, 'Successfully Updated', 200);
    }

}
