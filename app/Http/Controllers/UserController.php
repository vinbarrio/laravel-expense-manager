<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Check if admin is making the request to store.
        if ($request->user()->user_role_id == 1) {
            return Inertia::render('User/Index', [
                'users' => User::all()->map(fn($user) => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role_id' => $user->user_role_id,
                    'role' => $user->userRole->role,
                    'created_at' => date('Y-m-d', strtotime($user->created_at)),
                ]),
                'userRoles' => UserRole::all()->map(fn($user) => [
                    'id' => $user->id,
                    'role' => $user->role,
                ]),
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Check if admin is making the request to store.
        if ($request->user()->user_role_id == 1) {
            $newUser = Validator::make($request->all(), [
                'name' => 'required',
                'email' => ['required', 'email'],
                'password' => 'required',
                'role' => ['required', 'exists:App\Models\UserRole,id']
            ]);
            // Check validation failure
            if ($newUser->fails()) {
                return redirect('/users')->withErrors($newUser)->with('message', "Invalid Input. Please try again.");
            }
            

            $newUserValidated = $newUser->validated();
            User::create([
                'name' => $newUserValidated['name'],
                'email' => $newUserValidated['email'],
                'password' => $newUserValidated['password'],
                'user_role_id' => $newUserValidated['role'],
            ]);
            return redirect('/users')->with('message', 'Successfully Added New User');
        

            

            

        } else {
            return redirect()->back()->with('message', 'Not Authorized to Add User');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Check if admin is making the request to udpate.
        if ($request->user()->user_role_id == 1) {
            $newUserDetail = Validator::make($request->all(), [
                'id' => 'required',
                'name' => 'required',
                'email' => ['required', 'email'],
                'password' => 'required',
                'role' => ['required', 'exists:App\Models\UserRole,id']
            ]);

            // Check validation failure
            if ($newUserDetail->fails()) {
                return redirect('/users')->withErrors($newUserDetail)->with('message', "Invalid Input. Please try again.");
            }
            

            $newUserDetailValidated = $newUserDetail->validated();

            if ($request->id == $newUserDetailValidated['id']) {
                User::find($request->input('id'))->update([
                    'name' => $newUserDetailValidated['name'],
                    'email' => $newUserDetailValidated['email'],
                    'password' => $newUserDetailValidated['password'],
                    'user_role_id' => $newUserDetailValidated['role'],
                    ]);
                return redirect()->back()
                        ->with('message', ' Successfully Updated User.');
            }

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        // Check if admin is making the request to udpate.
        if ($request->user()->user_role_id == 1) {
            $validateDelete = Validator::make($request->all(), [
                'id' => ['required', 'exists:App\Models\user,id']
            ]);

            // Check validation failure
            if ($validateDelete->fails()) {
                return redirect('/users')->withErrors($newUserDetail)->with('message', "Invalid Input. Please try again.");
            }
            

            $validatedDeleteId = $validateDelete->validated();

            if ($request->has('id') == $validatedDeleteId['id']) {
                User::find($request->input('id'))->delete();
                return redirect()->back()
                        ->with('message', ' Successfully Deleted User.');
            }

        }
    }
}
