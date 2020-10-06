<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    public function retrieveRole(Request $request) {
        $role = Role::get('name');
        return response().json(compact('role'));
    }
}
