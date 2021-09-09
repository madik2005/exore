<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{   
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
    * Show the user create form.
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */
    public function create(User $user)
    {
        $this->authorize('createUser', $user);
        return view('admin.users.create');
    }

    /**
     * Create a new user after validate data.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    protected function store(Request $request, User $user)
    {
        $this->authorize('createUser', $user);
        $this->validate($request,[
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:1', 'confirmed'],
        ]);
        User::create([
            'email' => (string) $request->email,
            'password' => Hash::make($request->password),
        ]);
        return redirect()->route('admin.users.create')->with('success', 'User created'); 
    }


}
