<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;


class UserController extends Controller
{

    public function index()
    {
        return User::all();
    }

    public function store(StoreUserRequest $request, User $user)
    {
        $user = User::create($request->validated());
        $user->cart()->create();
        return $user;

    }

    public function show(User $user)
    {
        return $user->loadMissing('cart');
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        return $user;
    }

    public function destroy(User $user)
    {
        $response = $user->delete();
        return response()->json([
            'message' => $response ? 'Usuário removido com sucesso!' : 'Ocorreu um erro.',
        ], $response ? 200 : 500);
    }
}
