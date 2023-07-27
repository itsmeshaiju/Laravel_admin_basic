<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Permission::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $showUrl = route('permission.show', $row->id);
                    $actionBtn = '<form method="POST" action="'.route('permission.destroy', $row->id).'" style="display:inline">
                    '.method_field('DELETE').'
                    '.csrf_field().'
                    <button type="submit" onclick="return confirm(\'Are you sure you want to delete this item?\')" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                </form>';
                    

                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $page_name = 'Permission';
        return view('admin.permission.index', compact('page_name'));
            
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required |unique:permissions,name',

        ]);

        $input = $request->all();
        $name = strtolower($input['name']);
        $name  =  str_replace(" ", "-", $name);
        if (Permission::where('name', '=', $name)->exists()) {
            $validator = ["The name has already been taken"];
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $input['name'] = $name;
        $input['guard_name'] = 'web';
        $Permission = Permission::create($input);
        //set actvity log here
        \LogActivity::addToLog('Permission created successfully');
        return redirect()->route('permission.index')
            ->with('success', 'Permission created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Permission::find($id)->delete();
        //set actvity log here
        \LogActivity::addToLog('Permission deleted successfully');
        return redirect()->route('permission.index')
            ->with('success', 'Permission deleted successfully');
    }
}
