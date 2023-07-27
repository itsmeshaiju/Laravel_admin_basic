<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    private $permission;
    public function __construct()
    {
        $this->permission = 'user';
        $this->middleware('permission:' . $this->permission . '-list|' . $this->permission . '-create|' . $this->permission . '-edit|' . $this->permission . '-show|' . $this->permission . '-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:' . $this->permission . '-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:' . $this->permission . '-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:' . $this->permission . '-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {


        if ($request->ajax()) {
            $data = User::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $showUrl = route('users.show', $row->id);
                    $actionBtn = "";
                    if (in_array('superadmin', $row->getRoleNames()->toArray()) == false) {
                        if (Gate::check($this->permission . '-edit')) {
                            $actionBtn = ' <a class="btn btn-primary" href="' . route('users.edit', $row->id) . '"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                        }
                        if (Gate::check($this->permission . '-delete')) {
                            $actionBtn .= '<form method="POST" action="' . route('users.destroy', $row->id) . '" style="display:inline">
                    ' . method_field('DELETE') . '
                    ' . csrf_field() . '
                    <button type="submit" onclick="return confirm(\'Are you sure you want to delete this item?\')" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                </form>';
                        }
                    }
                    if (Gate::check($this->permission . '-show')) {
                        $actionBtn .= '<a class="btn btn-info" href="' . route('users.show', $row->id) . '"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                    }

                    return $actionBtn;
                })->addColumn('role', function ($row) {
                    $role = "";
                    if (!empty($row->getRoleNames())) {
                        foreach ($row->getRoleNames() as $v) {
                            $role =    '<label class="badge badge-success">' . $v . '</label>';
                        }
                    }
                    return $role;
                })
                ->addColumn('status', function ($row) {

                    if ($row->status == 0) {
                        $status =    '<label class="badge badge-danger"> Deactivated </label>';
                    } else {
                        $status =    '<label class="badge badge-success"> Activated </label>';
                    }


                    return $status;
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('status') == '0' || $request->get('status') == '1') {
                        $instance->where('status', $request->get('status'));
                    }
                    if ($request->get('name') != "") {
                        $instance->where('name', 'LIKE', '%' . $request->get('name') . '%');
                        
                    }
                    if ($request->get('role') != "") {
                        $instance->whereHas('roles', function ($instance) use ($request) {
                            $instance->where('name', $request->get('role'));
                        });
                    }
                 
                    if ($request->get('search') !=""){
                        $instance->where('name', 'LIKE', '%' . $request->get('search') . '%')
                        ->orWhere('email', 'LIKE', '%' . $request->get('search') . '%');
                    }
                })
                ->rawColumns(['action', 'role', 'status'])
                ->make(true);
        }
        $page_name = 'User';
        $roles = Role::pluck('name')->all();
        return view('admin.users.index', ['page_name' => $page_name, 'permission' => $this->permission, 'roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $page_name = 'User';
        $roles = Role::pluck('name')->all();
        return view('admin.users.create', ['page_name' => $page_name, 'roles' => $roles]);
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'status' => 'required',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));
        //set actvity log here
        \LogActivity::addToLog('User created successfully');
        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {
        $user = User::find($id);
        $page_name = 'User';
        return view('admin.users.show', compact('user', 'page_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        $page_name = 'User';

        return view('admin.users.edit', compact('user', 'roles', 'userRole', 'page_name'));
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
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));
        //set actvity log here
        \LogActivity::addToLog('User updated successfully');
        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        User::find($id)->delete();
        //set actvity log here
        \LogActivity::addToLog('User deleted successfully');
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }
}
