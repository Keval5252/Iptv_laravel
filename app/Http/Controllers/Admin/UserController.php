<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Setting;
use App\Models\AppVersion;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\Notification;
use Hash;
use Mail;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use function PHPUnit\Framework\isEmpty;

class UserController extends Controller
{
    public $user;
    function __construct()
    {
        $this->user = Auth::user();
        if (isset($this->user->id) && $this->user->id != 1) {
            // user permission
            $this->middleware('permission:users-list|users-create|users-edit|users-status', ['only' => ['index', 'store']]);
            $this->middleware('permission:users-create', ['only' => ['store']]);
            $this->middleware('permission:users-show', ['only' => ['get_user']]);
            $this->middleware('permission:users-edit', ['only' => ['getUser', 'store']]);
            $this->middleware('permission:users-status', ['only' => ['getUser', 'changeStatus']]);

            // version permission
            $this->middleware('permission:version-view|version-update', ['only' => ['index', 'version_update']]);
            $this->middleware('permission:version-update', ['only' => ['version_update']]);
            // setting permission
            $this->middleware('permission:setting-view|setting-update', ['only' => ['index', 'setting_update']]);
            $this->middleware('permission:setting-update', ['only' => ['setting_update']]);
        }
    }
    public function index(Request $request)
    {
        return view('admin.users.list');
    }

    public function users(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'user_name',
            2 => 'email',
            3 => 'status',
        );
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $users = User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['user']);
        });
        if ($request->search['value'] != null) {
            $users = $users->where('first_name', 'LIKE', '%' . $request->search['value'] . '%')
                ->orWhere('last_name', 'LIKE', '%' . $request->search['value'] . '%')
                ->orWhere('email', 'LIKE', '%' . $request->search['value'] . '%');
        }
        if ($request->length != '-1') {
            $users = $users->take($request->length);
        } else {
            $users = $users->take(User::count());
        }
        $users = $users->skip($request->start)
            ->orderBy($order, $dir)
            ->get();

        $data = array();
        if (!empty($users)) {
            foreach ($users as $user) {
                $url = route('admin.user.get', ['user_id' => $user->id]);
                $statusUrl = route('admin.user.status.change', ['user_id' => $user->id]);
                $checked = $user->status == 1 ? 'checked' : '';
                $nestedData['id'] = $user->id;
                $nestedData['first_name'] = $user->first_name;
                $nestedData['last_name'] = $user->last_name;
                $nestedData['user_name'] = $user->user_name;
                $nestedData['email'] = $user->email;
                $nestedData['status'] = "<div class='custom-control custom-switch'>
                                            <input type='radio' class='custom-control-input active' data-url='$statusUrl' id='active$user->id' name='active$user->id' $checked>
                                            <label class='custom-control-label' for='active$user->id'></label>
                                        </div>";
                $nestedData['action'] = "<button class='edit-cat btn btn-outline-warning btn-sm btn-icon' data-toggle='modal' data-target='#default-example-modal' data-url=' $url '><i class='fal fa-pencil'></i></button>";
                $data[] = $nestedData;
            }
        }
        return response()->json([
            'draw' => $request->draw,
            'data' => $data,
            'recordsTotal' => User::count(),
            'recordsFiltered' => $request->search['value'] != null ? $users->count() : User::count(),
        ]);
    }
    public function getUser(Request $request)
    {
        $user = User::find($request->user_id);
        return response()->json(['data' => $user]);
    }
    public function changeStatus(Request $request)
    {
        $user = User::find($request->user_id);
        if ($user->status == 1) {
            $user->status = 2;
        } else {
            $user->status = 1;
        }
        $user->save();
        return response()->json(['status' => 'success']);
    }
    public function store(Request $request)
    {
        if ($request->user_id != null) {
            $user = User::find($request->user_id);
        } else {
            $user = new User;
        }
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->status = $request->status;
        $user->save();
        return response()->json(['status' => 'success']);
    }
    public function profile()
    {
        $user = User::find(Auth::id());
        return view('admin.users.profile', compact('user'));
    }
    public function update_profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'photo' => 'nullable|image|mimes:png,jpeg,jpg,svg,ico|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
        }
        try {
            $user = User::find(Auth::id());
            $user->name = $request->first_name;
            $user->email = $request->email;
            if ($request->hasfile('photo')) {
                $file = $request->file('photo');
                $filename = time() . $file->getClientOriginalName();
                $file->move(public_path() . '/user/', $filename);
                $user->photo = $filename;
            }
            $user->save();
            return response()->json(['status' => 'success', 'data' => $user]);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function password()
    {
        return view('admin.users.password');
    }

    public function change_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current' => 'required|max:255',
            'password' => 'required|max:255|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
        }

        try {
            $user = User::find(Auth::id());
            if ($user) {
                if (Hash::check($request->current, $user->password)) {
                    $user->password =  bcrypt($request->password);
                    $user->save();
                    return response()->json(['status' => 'success']);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Enter valid current password!']);
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function admin_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
        }
        $user = User::where('email', $request->email)->first();
        if ($user) {
            // if ($user->roles[0]->name != 'Admin' && $user->roles[0]->name != 'Developer') {
            if($user->user_type != 1){   
                return response()->json(['status' => 'error', 'message' => 'Enter valid email or password!']);
            }
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                return response()->json(['status' => 'success']);
            }
        }

        return response()->json(['status' => 'error', 'message' => 'Enter valid email or password!']);
    }
    public function app_version()
    {
        $AppVersion = AppVersion::latest()->first();
        return view('admin.appversion', compact('AppVersion'));
    }
    public function version_update(Request $request)
    {
        try {
            $AppVersion = AppVersion::latest()->first();
            $AppVersion->ios = $request->ios;
            $AppVersion->android = $request->android;
            $AppVersion->forcefully = $request->forcefully;
            $AppVersion->save();
            return response()->json(['status' => 'success', 'data' => $AppVersion]);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function app_setting()
    {
        $setting = Setting::latest()->first();
        return view('admin.setting', compact('setting'));
    }

    public function setting_update(Request $request)
    {
        try {
            $setting = Setting::latest()->first();
            $setting->name = $request->name;
            $setting->url = $request->url;
            $setting->push_token = $request->push_token;
            $setting->api_log = $request->api_log;
            $setting->host = $request->host;
            $setting->port = $request->port;
            $setting->email = $request->email;
            $setting->password = $request->password;
            $setting->from_address = $request->from_address;
            $setting->from_name = $request->from_name;
            $setting->encryption = $request->encryption;
            $setting->save();
            return response()->json(['status' => 'success', 'data' => $setting]);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function forgot_password()
    {
        return view('auth.forgot');
    }

    public function password_mail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
        }

        $user = User::where('email', $request->email)->first();
        if (empty($user)) {
            return response()->json(['status' => 'error', 'message' => 'This email not registered']);
        }

        try {
            $newPass = substr(md5(time()), 0, 10);
            $user->password = bcrypt($newPass);
            $user->save();
            $data = [
                'username' => $user->user_name,
                'password' => $newPass
            ];
            $email = $user->email;
            Mail::send('mail.forgot', $data, function ($message) use ($email) {
                $message->to($email, 'test')->subject('Forgot Password');
            });
            return response()->json(['status' => 'success']);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function app_notification()
    {
        return view('admin.notification.send');
    }

    public function send_notification(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'message' => 'required'
        ]);

        if ($request->device_type == 'all') {
            $users = User::pluck('device_token')->all();
            $users_id = User::pluck('id')->all();
        } else {
            $users = User::where('device_type', $request->device_type)->pluck('device_token');
            $users_id = User::where('device_type', $request->device_type)->pluck('id');
        }

        $chunkedArray = array_chunk($users, 999);


        foreach ($chunkedArray as $array) {
            $data = [
                "registration_ids" => $array,
                "notification" => [
                    "title" => $request->title,
                    "body" => $request->message,
                ]
            ];
        }
        $dataString = json_encode($data);
        $setting = Setting::first();

        $headers = [
            'Authorization: key=' . $setting->push_token,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        $notifications = [];
        foreach ($users_id as $id) {
            $notifications[] = [
                'user_id' => $id,
                'title' => $request->title,
                'message' => $request->message,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        Notification::insert($notifications);

        return $result;
    }
}
