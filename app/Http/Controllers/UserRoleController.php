<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Validator;


class UserRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('UserRole/Index', [
            'userRoles' => UserRole::all()->map(fn($userRole) => [
                'id' => $userRole->id,
                'description' => $userRole->description,
                'role' => $userRole->role,
                'created_at' => date('Y-m-d', strtotime($userRole->created_at)),
            ]),
        ]);
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
        // Check if admin is making the request to add new user.
        if ($request->user()->user_role_id == 1) {
            $userRoleDetail = Validator::make($request->all(), [
                'description' => 'required',
                'role' => 'required',
            ]);

            // Check validation failure
            if ($userRoleDetail->fails()) {
                return redirect()->back()->withErrors($userRoleDetail)->with('message', "Invalid Input. Please try again.");
            }
            

            $userRoleDetailValidated = $userRoleDetail->validated();
            UserRole::Create([
                'description' => $userRoleDetailValidated['description'],
                'role' => $userRoleDetailValidated['role'],
            ]);

            return redirect()->back()->with('message', 'Successfully Added New Role');

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
            $userRoleDetail = Validator::make($request->all(), [
                'id' => ['required', 'exists:App\Models\UserRole,id'],
                'description' => 'required',
                'role' => 'required',
            ]);

            // Check validation failure
            if ($userRoleDetail->fails()) {
                return redirect()->back()->withErrors($userRoleDetail)->with('message', "Invalid Input. Please try again.");
            }
            

            $userRoleDetailValidated = $userRoleDetail->validated();

            // Make the admin role not editable.
            if($request->id == 1 || $userRoleDetailValidated['id'] == 1) {
                return redirect()->back()->with('message', "Admin Role is not editable.");
            }

            if ($request->id == $userRoleDetailValidated['id']) {
                UserRole::find($request->input('id'))->update([
                    'description' => $userRoleDetailValidated['description'],
                    'role' => $userRoleDetailValidated['role'],
                    ]);
                return redirect()->back()
                        ->with('message', ' Successfully Updated Role.');
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
                'id' => ['required', 'exists:App\Models\UserRole,id'],
            ]);

            // Check validation failure
            if ($validateDelete->fails()) {
                return redirect()->back()->withErrors($validateDelete)->with('message', "Invalid Input. Please try again.");
            }
            

            $validatedDeleteId = $validateDelete->validated();


            if ($request->id == $validatedDeleteId['id']) {
                UserRole::find($request->input('id'))->delete();
                return redirect()->back()
                        ->with('message', ' Successfully Deleted Role.');
            }

        }
    }
}
