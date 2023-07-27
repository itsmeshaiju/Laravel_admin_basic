<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Gate;
class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $permission;
    public function __construct()
    {
        $this->permission = 'plan';
        $this->middleware('permission:' . $this->permission . '-list|' . $this->permission . '-create|' . $this->permission . '-edit|' . $this->permission . '-show|' . $this->permission . '-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:' . $this->permission . '-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:' . $this->permission . '-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:' . $this->permission . '-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Plan::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $showUrl = route('plan.show', $row->id);
                    $actionBtn = "";
                        if (Gate::check($this->permission . '-edit')) {
                            $actionBtn = ' <a class="btn btn-primary" href="' . route('plan.edit', $row->id) . '"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                        }
                        if (Gate::check($this->permission . '-delete')) {
                            $actionBtn .= '<form method="POST" action="' . route('plan.destroy', $row->id) . '" style="display:inline">
                    ' . method_field('DELETE') . '
                    ' . csrf_field() . '
                    <button type="submit" onclick="return confirm(\'Are you sure you want to delete this item?\')" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                </form>';
                        }
                    if (Gate::check($this->permission . '-show')) {
                        $actionBtn .= '<a class="btn btn-info" href="' . route('plan.show', $row->id) . '"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                    }
            

                    return $actionBtn;
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
                    if ($request->get('title') != "") {
                        $instance->where('title', 'LIKE', '%' . $request->get('title') . '%');
                        
                    }
                   
                })
                ->rawColumns(['action', 'role', 'status'])
                ->make(true);
        }
        $page_name = 'Plan';
        
        return view('admin.plan.index', ['page_name' => $page_name, 'permission' => $this->permission]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page_name = 'Plan';
        return view('admin.plan.create', ['page_name' => $page_name]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:plans,title',
            'day' => 'required',
            'status' => 'required',
          
        ]);

        $input = $request->all();
        $plan = Plan::create($input);
       
        //set actvity log here
        \LogActivity::addToLog('Plan created successfully');
        return redirect()->route('plan.index')
            ->with('success', 'Plan created successfully');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $plan = Plan::find($id);
        $page_name = 'Plan';
        return view('admin.plan.show', compact('plan', 'page_name'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $plan = Plan::find($id);
        $page_name = 'Plan';
        return view('admin.plan.edit', compact('plan', 'page_name'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            
            'title' => 'required|unique:plans,title,'.$id,
            'day' => 'required',
            'status' => 'required',
          
        ]);


        $input = $request->all();
        $plan = Plan::find($id);
        $plan->update($input);
        //set actvity log here
        \LogActivity::addToLog('Plan updated successfully');
        return redirect()->route('plan.index')
            ->with('success', 'Plan updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Plan::find($id)->delete();
        //set actvity log here
        \LogActivity::addToLog('Plan deleted successfully');
        return redirect()->route('plan.index');
    }
}
