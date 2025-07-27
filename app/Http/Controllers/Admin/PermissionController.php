<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB, Auth;

class PermissionController extends Controller
{
    public $user;
    function __construct()
    {
        $this->user = Auth::user();
        if (isset($this->user->id) && $this->user->id != 1) {
            $this->middleware('permission:permission-list|permission-create|permission-edit|permission-delete', ['only' => ['index', 'store']]);
            $this->middleware('permission:permission-create', ['only' => ['store']]);
            $this->middleware('permission:permission-edit', ['only' => ['getpermission', 'store']]);
            $this->middleware('permission:permission-delete', ['only' => ['delete']]);
        }
    }

    public function index(Request $request)
    {
        $permissions = Permission::query();
        if ($request->search != null) {
            $permissions = $permissions->where('id', 'LIKE', '%' . $request->search . '%')
                ->orWhere('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('points', 'LIKE', '%' . $request->search . '%');
        }
        if ($request->sortby != null && $request->sorttype) {
            $permissions = $permissions->orderBy($request->sortby, $request->sorttype);
        } else {
            $permissions = $permissions->orderBy('id', 'ASC');
        }

        if ($request->perPage != null) {
            $permissions = $permissions->paginate($request->perPage);
        } else {
            $permissions = $permissions->paginate(10);
        }
        if ($request->ajax()) {
            return response()->json(view('admin.permission.permission_data', compact('permissions'))->render());
        }
        return view('admin.permission.index', compact('permissions'));
    }

    public function permission(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'guard_name',
            3 => 'action',
        );

        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $permissions = Permission::query();
        if ($request->search['value'] != null) {
            $permissions = $permissions->where('id', 'LIKE', '%' . $request->search['value'] . '%')
                ->orWhere('name', 'LIKE', '%' . $request->search['value'] . '%')
                ->orWhere('guard_name', 'LIKE', '%' . $request->search['value'] . '%');
        }
        if ($request->length != '-1') {
            $permissions = $permissions->take($request->length);
        } else {
            $permissions = $permissions->take(Permission::count());
        }
        $permissions = $permissions->skip($request->start)
            ->orderBy($order, $dir)
            ->get();

        $data = array();
        if (!empty($permissions)) {
            foreach ($permissions as $permission) {
                $url = route('admin.permission.get', ['permission_id' => $permission->id]);
                $urls = route('admin.permission.delete', ['permission_id' => $permission->id]);
                $nestedData['id'] = $permission->id;
                $nestedData['name'] = $permission->name;
                $nestedData['guard_name'] = $permission->guard_name;
                $nestedData['action'] =  "<td>
                                             <button class='edit-cat btn btn-outline-warning btn-sm btn-icon' data-url=' $url ' data-toggle='modal' data-target='#default-example-modal'><i class='fal fa-pencil'></i></button>
                                             <button class='delete-cat btn btn-outline-danger btn-sm btn-icon'  data-url=' $urls '><i class='fal fa-trash'></i></button>
                                         </td>";
                $data[] = $nestedData;
            }
        }
        return response()->json([
            'draw' => $request->draw,
            'data' => $data,
            'recordsTotal' => Permission::count(),
            'recordsFiltered' => $request->search['value'] != null ? $permissions->count() : Permission::count(),
        ]);
    }


    public function getpermission(Request $request)
    {
        $permission = Permission::find($request->permission_id);
        return $permission;
        // return response()->json(['data'=>$product]);
    }
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                // 'guard_name' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
            }
            if ($request->permission_id != null) {
                $permission = Permission::find($request->permission_id);
            } else {
                $permission = new Permission();
            }

            $permission->name = $request->name;
            // $permission->guard_name = $request->guard_name;
            $permission->save();
            return response()->json(['status' => 'success']);
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'message' => ""]);
        }
    }


    public function delete(Request $request)
    {
        $permission = Permission::find($request->permission_id);
        $permission->delete();
        return response()->json(['status' => 'success']);
    }
}
