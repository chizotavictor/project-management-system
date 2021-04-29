<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\User;
use Throwable;

class StaffController extends Controller
{
    private $userRepository;

    public function __construct() {
        $this->userRepository = new UserRepository;
    }

    public function index(Request $request, User $user) {
        $user = $user->newQuery();

        if(isset($request->name))
        {
            $user->where('name', $request->name);
        }
        if(isset($request->email))
        {
            $user->where('email', $request->email);
        }
        $user->orderBy('id', 'DESC');
        $users = $user->paginate(20);
        return view('admin.admin-all-users')->with(['users' => $users]);
    }

    public function addNewUser(Request $request) {
        return view('admin.admin-add-user', ['user' => null]);
    }

    public function editUser(Request $request, $user_id)
    {
        $user = $this->userRepository->find($user_id);
        if(!isset($user)) abort(404);
        return view('admin.admin-add-user', ['user' => $user]);
    }

    public function updateUser(Request $request) {
        $this->validate($request, [
            'is_admin'      => 'required',
            'name'          => 'required|string|min:5',
            'email'         => 'required',
            'phone_number'  => 'required|min:11|max:14',
        ]);

        try {
            $this->userRepository->update(
                [
                    'is_admin' => $request->is_admin,
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone_number' => $request->phone_number,
                    'github_link' => $request->github_link
                ],
                ['id' => $request->id]
            );
            $request->session()->flash('success', "User updated successfully.");
        } catch (Throwable $th) {
            $request->session()->flash('error', "Error occurred while updating this user.");
        }
        return redirect()->back();
    }

    public function createNewUser(Request $request) {
        $this->validate($request, [
            'name'          => 'required|string|min:5',
            'email'         => 'required|email|unique:users',
            'phone_number'  => 'required|min:11|max:14|unique:users',
            'password'      => 'required|min:8|confirmed'
        ]);

        $data = $request->only(['name', 'email', 'phone_number', 'password']);
        $data['password'] = Hash::make($data['password']);

        try {
            $this->userRepository->insert($data);
            $request->session()->flash('success', "User registered successfully.");
        } catch (\Throwable $th) {
            $request->session()->flash('error', "Error occurred while adding new user record.");
        }

        return redirect()->back();
    }
}
