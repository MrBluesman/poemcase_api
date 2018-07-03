<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return response()->json([
            'data' => $roles
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validationRules = [
            'name' => 'required|min:1|max:20|unique:roles,name'
        ];

        $rolesValidator = Validator::make($request->all(), $validationRules);

        if($rolesValidator->fails())
        {
            return response()->json([
                'error' => 'true',
                'message' => $rolesValidator->messages()
            ], 400);
        }

        $role = Role::create($request->all());
        return response()->json([
            'message' => 'Role created',
            'data' => $role
        ], 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return response()->json([
            'data' => $role
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $validationRules = [
            'name' => 'required|min:1|max:20|unique:roles,name,' . $role->id
        ];

        $rolesValidator = Validator::make($request->all(), $validationRules);

        if($rolesValidator->fails())
        {
            return response()->json([
                'error' => 'true',
                'message' => $rolesValidator->messages()
            ], 400);
        }

        $role->update($request->all());
        return response()->json([
            'message' => 'Role updated',
            'data' => $role
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Role $role
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json([
            'message' => 'Role deleted',
            'data' => $role
        ], 200);
    }
}
