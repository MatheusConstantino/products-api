<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userRepository->getAllUsers();
        return response()->json($users);
    }

    public function show($id)
    {
        $user = $this->userRepository->getUserById($id);
        return response()->json($user);
    }

    public function store(CreateUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        $user = $this->userRepository->createUser($data);

        return response()->json($user, 201);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $data = $request->validated();
        if(isset($data['password'])){
            $data['password'] = Hash::make($data['password']);
        }

        $user = $this->userRepository->updateUser($id, $data);

        return response()->json($user, 201);
    }

    public function destroy($id)
    {
        $this->userRepository->deleteUser($id);
        return response()->json(null, 204);
    }
}

