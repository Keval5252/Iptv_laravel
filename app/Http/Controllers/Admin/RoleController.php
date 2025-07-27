<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB, Auth;

class RoleController extends Controller
{
    public $user;
    function __construct()
    {
        $this->user = Auth::user();
        if ($this->user->id != 1) {
            $this->middleware('permission:acl-role-list|acl-role-create|acl-role-edit|acl-role-delete', ['only' => ['index', 'store']]);
            $this->middleware('permission:acl-role-create', ['only' => ['create', 'store']]);
            $this->middleware('permission:acl-role-edit', ['only' => ['get_role', 'store']]);
            $this->middleware('permission:acl-role-delete', ['only' => ['delete']]);
        }
    }

    public function create(Request $request)
    {
        $permission = Permission::get();
        return view('admin.acl-role.save', compact('permission'));
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $aclRoles = Role::where('id','!=',1)->where('id','!=',$user->roles[0]->id)->orderBy('id', 'DESC');
        if ($request->search != null) {
            $aclRoles  = $aclRoles->where('category_name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('id', 'LIKE', '%' . $request->search['value'] . '%');
        }
        if ($request->sortby != null && $request->sorttype) {
            $aclRoles  = $aclRoles->orderBy($request->sortby, $request->sorttype);
        } else {
            $aclRoles = $aclRoles->orderBy('id', 'desc');
        }

        if ($request->perPage != null) {
            $aclRoles = $aclRoles->paginate($request->perPage);
        } else {
            $aclRoles = $aclRoles->paginate(10);
        }
        if ($request->ajax()) {
            return response()->json(view('admin.acl-role.index', compact('aclRoles'))->render());
        }
        return view('admin.acl-role.index', compact('aclRoles'));
    }

    public function roles(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'action',

        );
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $user = Auth::user();
        $aclRoles = Role::query()->where('id','!=',1)->where('id','!=',$user->roles[0]->id);
        if ($request->search['value'] != null) {
            $aclRoles = $aclRoles->where('id', 'LIKE', '%' . $request->search['value'] . '%')
                ->orWhere('plan_title', 'LIKE', '%' . $request->search['value'] . '%')
                ->orWhere('plan_description', 'LIKE', '%' . $request->search['value'] . '%')
                ->orWhere('duration', 'LIKE', '%' . $request->search['value'] . '%')
                ->orWhere('post_allowed', 'LIKE', '%' . $request->search['value'] . '%')
                ->orWhere('customer_allowed', 'LIKE', '%' . $request->search['value'] . '%')
                ->orWhere('privilege_customers', 'LIKE', '%' . $request->search['value'] . '%')
                ->orWhere('price', 'LIKE', '%' . $request->search['value'] . '%');
        }
        if ($request->sortby != null && $request->sorttype) {
            $aclRoles = $aclRoles->orderBy($request->sortby, $request->sorttype);
        } else {
            $aclRoles = $aclRoles->orderBy('id', 'desc');
        }
        if ($request->length != '-1') {
            $aclRoles = $aclRoles->take($request->length);
        } else {
            $aclRoles = $aclRoles->take(Role::count());
        }
        $aclRoles = $aclRoles->skip($request->start)
            ->orderBy($order, $dir)
            ->get();

        $data = array();
        if (!empty($aclRoles)) {
            foreach ($aclRoles as $aclRole) {
                $plan_data = [];
                $url = route('admin.acl-role.get', ['role_id' => $aclRole->id]);
                $urls = route('admin.acl-role.delete', ['role_id' => $aclRole->id]);
                $nestedData['id'] = $aclRole->id;
                $nestedData['name'] = $aclRole->name;
                $nestedData['action'] =  "<td>
                                             <a class='btn btn-outline-warning btn-sm btn-icon' href=' $url ' data-target='.default-example-modal-left-lg'><i class='fal fa-pencil'></i></a>
                                             <button class='delete-cat btn btn-outline-danger btn-sm btn-icon'  data-url=' $urls '><i class='fal fa-trash'></i></button>
                                         </td>";
                $data[] = $nestedData;
            }
        }
        return response()->json([
            'draw' => $request->draw,
            'data' => $data,
            'recordsTotal' => Role::count(),
            'recordsFiltered' => $request->search['value'] != null ? $aclRoles->count() : Role::count(),
        ]);
    }


    public function get_role(Request $request)
    {
        $role = Role::find($request->role_id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $request->role_id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();
        return view('admin.acl-role.save', compact('role', 'permission', 'rolePermissions'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'permission' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
            }
            if (isset($request->role_id)) {
                $role = Role::find($request->role_id);
                $role->name = $request->input('name');
                $role->save();

                $role->syncPermissions($request->input('permission'));
                return redirect()->route('admin.acl-role')->with('success', 'Role Updated successfully');
            } else {
                $role = Role::create(['name' => $request->input('name')]);
                $role->givePermissionTo($request->input('permission'));
                return redirect()->route('admin.acl-role')->with('success', 'Role created successfully');
            }
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'message' => "message.somethingWrong"]);
        }
    }

    public function delete(Request $request)
    {
        try {
            $aclRoles = Role::find($request->role_id);
            $aclRoles->delete();
            return response()->json(['status' => 'success']);
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'message' => "message.somethingWrong"]);
        }
    }
}
