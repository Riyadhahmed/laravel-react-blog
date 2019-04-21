<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\Role as UserRole;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use View;
use DB;

class RoleController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      return view('backend.admin.role.all');
   }

   public function allRole(Request $request)
   {
      if ($request->ajax()) {
         DB::statement(DB::raw('set @rownum=0'));
         $userole = UserRole::get(['roles.*', DB::raw('@rownum  := @rownum  + 1 AS rownum')]);
         return Datatables::of($userole)
           ->addColumn('action', 'backend.admin.role.action')
           ->make(true);
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create(Request $request)
   {
      if ($request->ajax()) {
         $haspermision = auth()->user()->can('role-create');
         if ($haspermision) {
            $permission = Permission::get();
            $view = View::make('backend.admin.role.create', compact('permission'))->render();
            return response()->json(['html' => $view]);
         } else {
            abort(403, 'Sorry, you are not authorized to access the page');
         }
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
      if ($request->ajax()) {
         // Setup the validator
         $rules = [
           'name' => 'required|unique:roles',
           'permissions' => 'required',
         ];

         $validator = Validator::make($request->all(), $rules);
         if ($validator->fails()) {
            return response()->json([
              'type' => 'error',
              'errors' => $validator->getMessageBag()->toArray()
            ]);
         } else {
            $role = Role::create(['name' => $request->input('name')]);
            $permissions = explode(",", $request->input('permissions'));
            $role->syncPermissions($permissions);
            return response()->json(['type' => 'success', 'message' => "Successfully Created"]);
         }
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   /**
    * Display the specified resource.
    *
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
   public function show($id, Request $request)
   {
      if ($request->ajax()) {
         $haspermision = auth()->user()->can('role-view');
         if ($haspermision) {
            $role = Role::find($id);
            $permissions = $role->permissions()->get();
            $view = View::make('backend.admin.role.view', compact('role', 'permissions'))->render();
            return response()->json(['html' => $view]);
         } else {
            abort(403, 'Sorry, you are not authorized to access the page');
         }
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
   public function edit(Request $request, $id)
   {
      if ($request->ajax()) {
         $haspermision = auth()->user()->can('role-edit');
         if ($haspermision) {
            $role = Role::findOrFail($id);
            $permissions = Permission::all();
            $view = View::make('backend.admin.role.edit', compact('role', 'permissions'))->render();
            return response()->json(['html' => $view]);
         } else {
            abort(403, 'Sorry, you are not authorized to access the page');
         }
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request $request
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, Role $role)
   {
      if ($request->ajax()) {
         // Setup the validator
         $rules = [
           'name' => 'required|unique:roles,name,' . $role->id,
           'permissions' => 'required',
         ];

         $validator = Validator::make($request->all(), $rules);
         if ($validator->fails()) {
            return response()->json([
              'type' => 'error',
              'errors' => $validator->getMessageBag()->toArray()
            ]);
         } else {

            $role = Role::findOrFail($role->id);
            $role->name = $request->input('name');
            $role->save();

            $permissions = $request->input('permissions');

            if (isset($permissions)) {
               $role->syncPermissions($permissions);  //If one or more role is selected associate user to roles
            } else {
               //If no role is selected remove exisiting permissions associated to a role
               $p_all = Permission::all();//Get all permissions
               foreach ($p_all as $p) {
                  $role->revokePermissionTo($p); //Remove all permissions associated with role
               }
            }
            return response()->json(['type' => 'success', 'message' => "Successfully Created"]);
         }
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
   public function destroy(Request $request, $id)
   {
      if ($request->ajax()) {
         $haspermision = auth()->user()->can('role-delete');
         if ($haspermision) {
            $role = Role::findOrFail($id);
            $role->delete();
            return response()->json(['type' => 'success', 'message' => "Successfully Deleted"]);
         } else {
            abort(403, 'Sorry, you are not authorized to access the page');
         }
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }
}
