<?php

namespace Laraditz\PermissionPlus\Http\Controllers;

use Illuminate\Http\Request;
use Laraditz\PermissionPlus\Http\Requests\StorePermissionRequest;
use Laraditz\PermissionPlus\Http\Requests\UpdatePermissionRequest;
use Laraditz\PermissionPlus\Models\PermissionPlus;
use Laraditz\PermissionPlus\Models\PermissionPlusRole;
use Laraditz\PermissionPlus\Models\Role;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd(Route::getRoutes());
        // $roles = ['admin', 'manager', 'finance', 'registered'];
        // foreach ($roles as $role) {
        //     \Spatie\Permission\Models\Role::create(['name' => $role]);
        // }
        // $user = \App\Models\User::find(1);
        // $user->assignRole('admin');
        // $permission = \Spatie\Permission\Models\Permission::create(['name' => 'edit articles']);
        // $allGuards = collect(array_keys(config('auth.guards')))->mapWithKeys(fn ($item) => [$item => false]);

        $query = PermissionPlus::query();

        $query->search($request);

        // $query->dd();

        $permissions = $query->paginate();

        return view(config('permission-plus.prefix') . '::permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $methods = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS', 'HEAD'];

        return view(config('permission-plus.prefix') . '::permissions.create', compact('roles', 'methods'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermissionRequest $request)
    {
        $permission = PermissionPlus::create($request->validated());

        if ($permission && $request->roles) {
            $permission->roles()->sync($request->roles);
        }

        return redirect()->route(config('permission-plus.prefix') . '.permissions.index', $request->query())->with('success', 'Permission has been created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PermissionPlus  $permissionPlus
     * @return \Illuminate\Http\Response
     */
    public function edit(PermissionPlus $permission)
    {
        $roles = Role::all();
        $methods = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS', 'HEAD'];

        return view(config('permission-plus.prefix') . '::permissions.edit', compact('permission', 'roles', 'methods'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PermissionPlus  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionRequest $request, PermissionPlus $permission)
    {
        $permission->update($request->validated());

        $permission->roles()->sync($request->roles);

        return redirect()->route(config('permission-plus.prefix') . '.permissions.index', $request->query())->with('message', 'Permission Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PermissionPlus  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(PermissionPlus $permission)
    {
        $permission->delete();

        return redirect()->route(config('permission-plus.prefix') . '.permissions.index')->with('message', 'Permission has been deleted successfully.');
    }


    public function generate(Request $request)
    {
        app('permission-plus')->generatePermissions(!!$request->overwrite);

        return redirect()->route(config('permission-plus.prefix') . '.permissions.index')->with('message', 'Permission Generated Successfully');
    }
}
