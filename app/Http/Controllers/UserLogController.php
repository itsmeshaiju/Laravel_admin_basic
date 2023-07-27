<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\LogActivity ;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Gate;
class UserLogController extends Controller

{
    /**
     * Display a listing of the resource.
     */

     private $permission;
     function __construct()
     {
         $this->permission = 'log';
         $this->middleware('permission:'. $this->permission.'-list|'. $this->permission.'-create|'. $this->permission.'-edit|'.$this->permission.'-show|'. $this->permission.'-delete', ['only' => ['index','store']]);
        $this->middleware('permission:'. $this->permission.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'. $this->permission.'-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:'. $this->permission.'-delete', ['only' => ['destroy']]);
     }
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = LogActivity::query();
           
            return DataTables::of($data)
           
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                   
                    $actionBtn = "";
                    $showUrl = route('permission.show', $row->id);
                    if (Gate::check($this->permission . '-delete')) {
                    $actionBtn = '<form method="POST" action="'.route('userlog.destroy', $row->id).'" style="display:inline">
                    '.method_field('DELETE').'
                    '.csrf_field().'
                    <button type="submit" onclick="return confirm(\'Are you sure you want to delete this item?\')" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                </form>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $page_name = 'User Log';
        return view('admin.userLog.index', ['page_name' => $page_name, 'permission' => $this->permission]);
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
        //
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
        LogActivity::find($id)->delete();
       return redirect()->route('userlog.index')
                       ->with('success','User log deleted successfully');
    }
}
