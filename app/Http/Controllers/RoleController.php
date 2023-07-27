<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $permission;

    function __construct()
    {


        // $user = User::find(Auth::user()->id); 
        // if ($user->role_id == 1) {

        //  $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        //  $this->middleware('permission:role-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:role-delete', ['only' => ['destroy']]);
        //  return true;
        // }


        $this->permission = 'role';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        if ($request->ajax()) {
            $data = Role::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $showUrl = route('roles.show', $row->id);
                    $actionBtn = "";
                    if (Gate::check($this->permission . '-edit')) {
                        $actionBtn .= ' <a class="btn btn-primary" href="' . route('roles.edit', $row->id) . '"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                    }
                    if ($row->name != 'superadmin') {
                        if (Gate::check($this->permission . '-delete')) {
                            $actionBtn .= '<form method="POST" action="' . route('roles.destroy', $row->id) . '" style="display:inline">
                    ' . method_field('DELETE') . '
                    ' . csrf_field() . '
                    <button type="submit" onclick="return confirm(\'Are you sure you want to delete this item?\')" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                </form>';
                        }
                        if (Gate::check($this->permission . '-show')) {
                            $actionBtn .= '<a class="btn btn-info" href="' . route('roles.show', $row->id) . '"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                        }
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $page_name  = 'Role';
        return view('admin.roles.index', ['page_name' => $page_name, 'permission' => $this->permission]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $permission = Permission::get();
        $page_name  = 'Role';
        return view('admin.roles.create', compact('permission', 'page_name'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));
        //set actvity log here
        \LogActivity::addToLog('Role created successfully');

        return redirect()->route('roles.index')
            ->with('success', 'Role created successfully');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {

        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();
        $page_name = 'Role';
        return view('admin.roles.show', compact('role', 'rolePermissions', 'page_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();
        $page_name = 'Role';
        return view('admin.roles.edit', compact('role', 'permission', 'rolePermissions', 'page_name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));
        //set actvity log here
        \LogActivity::addToLog('Role updated successfully');
        return redirect()->route('roles.index')
            ->with('success', 'Role updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        DB::table("roles")->where('id', $id)->delete();
        //set actvity log here
        \LogActivity::addToLog('Role deleted successfully');
        return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully');
    }
}
