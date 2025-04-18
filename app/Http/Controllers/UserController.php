<?php

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Carbon\Carbon;

class UserController extends Controller
{
    public function store(StoreUserRequest $request)
    {
        $userData = $request->validated(); 

        $userData['start_at'] = Carbon::createFromFormat('m/d/Y', $request->start_at)->format('Y-m-d');
        $userData['password'] = bcrypt($request->password);

        $user = User::create($userData);
        $user->roles()->sync($request->input('roles', []));

        // ... the rest of the method
    }
}