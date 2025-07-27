<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB, Hash, Auth;
use Illuminate\Support\Arr;
use App\Models\User;

class AclUserController extends Controller
{
    public $user;
    function __construct()
    {
        $this->user = Auth::user();
        if ($this->user->id != 1) {
            $this->middleware('permission:acl-user-list|acl-user-create|acl-user-edit|acl-user-delete', ['only' => ['index', 'store']]);
            $this->middleware('permission:acl-user-create', ['only' => ['create', 'store']]);
            $this->middleware('permission:acl-user-edit', ['only' => ['get_user', 'store']]);
            $this->middleware('permission:acl-user-delete', ['only' => ['delete']]);
        }
    }

    public function create(Request $request)
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('admin.acl-user.save', compact('roles'));
    }

    public function index(Request $request)
    {
        $aclUser = User::where('user_type', 1)->where('id','!=',1)->where('id','!=',Auth::user()->id)->orderBy('id', 'DESC');
        if ($request->search != null) {
            $aclUser  = $aclUser->where('category_name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('id', 'LIKE', '%' . $request->search['value'] . '%');
        }
        if ($request->sortby != null && $request->sorttype) {
            $aclUser  = $aclUser->orderBy($request->sortby, $request->sorttype);
        } else {
            $aclUser = $aclUser->orderBy('id', 'desc');
        }

        if ($request->perPage != null) {
            $aclUser = $aclUser->paginate($request->perPage);
        } else {
            $aclUser = $aclUser->paginate(10);
        }
        if ($request->ajax()) {
            return response()->json(view('admin.acl-user.index', compact('aclUser'))->render());
        }
        return view('admin.acl-user.index', compact('aclUser'));
    }

    public function roles(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'email',
            2 => 'name',
            3 => 'action',

        );
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $aclUser =  User::query()->where('user_type', 1)->where('id','!=',1)->where('id','!=',Auth::user()->id);
        if ($request->search['value'] != null) {
            $aclUser = $aclUser->where('id', 'LIKE', '%' . $request->search['value'] . '%');
        }
        if ($request->sortby != null && $request->sorttype) {
            $aclUser = $aclUser->orderBy($request->sortby, $request->sorttype);
        } else {
            $aclUser = $aclUser->orderBy('id', 'desc');
        }
        if ($request->length != '-1') {
            $aclUser = $aclUser->take($request->length);
        } else {
            $aclUser = $aclUser->take(User::where('user_type', 1)->count());
        }
        $aclUser = $aclUser->skip($request->start)
            ->orderBy($order, $dir)
            ->get();

        $data = array();
        if (!empty($aclUser)) {
            foreach ($aclUser as $aclRole) {
                $plan_data = [];
                $url = route('admin.acl-user.get', ['user_id' => $aclRole->id]);
                $urls = route('admin.acl-user.delete', ['user_id' => $aclRole->id]);
                $nestedData['id'] = $aclRole->id;
                $nestedData['email'] = $aclRole->email;
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
            'recordsTotal' =>  User::where('user_type', 1)->count(),
            'recordsFiltered' => $request->search['value'] != null ? $aclUser->count() :  User::where('user_type', 1)->count(),
        ]);
    }


    public function get_user(Request $request)
    {
        $user = User::find($request->user_id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        return view('admin.acl-user.save', compact('user', 'roles', 'userRole'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|',
                'password' => 'sometimes|same:confirm_password',
                'roles' => 'required'
            ]);
            if ($validator->fails()) {
                return Redirect()->back()->withErrors($validator->errors());
            }
            if (empty($request->user_id)) {
                $input = $request->all();
                if (!empty($input['password'])) {
                    $input['password'] = Hash::make($input['password']);
                }
                $user = new User();
                $user->email = $request->email;
                $user->password = bcrypt($request->password);
                $user->name = $request->name;
                $user->photo = "images.png";
                $user->user_name = $request->name;
                $user->user_type = 1;
                $user->save();

                $user->assignRole($request->input('roles'));
                return redirect()->route('admin.acl-user')->with('success', 'Role Updated successfully');
            } else {
                $input = $request->all();
                $user = User::find($request->user_id);
                $user->name = $request->name ?? $user->name;
                $user->user_type = 1;
                if (!empty($request->password)) {
                    $user->password = bcrypt($request->password);
                }

                $user->save();
                DB::table('model_has_roles')->where('model_id', $request->user_id)->delete();

                $user->assignRole($request->input('roles'));
                return redirect()->route('admin.acl-user')->with('success', 'Role created successfully');
            }
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'message' => "message.somethingWrong"]);
        }
    }


    public function delete(Request $request)
    {
        $aclUser =  User::where('user_type', 1)->find($request->user_id);
        $aclUser->delete();
        return response()->json(['status' => 'success']);
    }
}
