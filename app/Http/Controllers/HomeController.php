<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ValidationRules;
use Validator;
use Auth;
use App\Template;
use App\SavedReceiver;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function validator(array $data, $rules)
    {
        return Validator::make($data, $rules);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $user = Auth::user();
            if ($data["password"] == "") unset($data["password"]);
            if ($data["email"] == $user->email) unset($data["email"]);
            $validator = $this->validator($data, ValidationRules::UserRules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->messages());
            }
            $user->user_type = $data['user_type'];
            $user->fio = $data['fio'];
            $user->company = $data['company'];
            $user->phone = $data['phone'];
            $user->region = $data['region'];
            $user->city = $data['city'];
            $user->street = $data['street'];
            $user->building = $data['building'];
            $user->flat = $data['flat'];
            if (isset($data["password"])) $user->password = bcrypt($data['password']);
            $user->save();
        }
        return view('home.profile');
    }

    public function templates(Request $request)
    {
        if ($request->isMethod('post')) {
            $template = new Template([
                "uid" => Auth::user()->id,
                "name" => $request->input("name"),
                "template" => $request->input("tmp")
            ]);
            $template->save();
            return redirect()->back();
        }
        return view('home.templates');
    }
    public function get_templates(Request $request)
    {
        $user = Auth::user();
        $arr = Template::where("uid", $user->id)->get();
        return $arr;
    }

    public function del_template(Request $request)
    {
        $tid = $request->input("id");
        Template::where("id", $tid)->where("uid", Auth::user()->id)->delete();
    }

    public function saved_receivers(Request $request)
    {
        if ($request->isMethod('post')) {
            $uid = Auth::user()->id;
            $data = $request->all();
            $data["uid"] = $uid;
            SavedReceiver::create($data);
            return redirect()->back();
        }
        return view('home.saved_receivers');
    }

    public function get_receivers(Request $request)
    {
        $arr = SavedReceiver::where("uid", Auth::user()->id)->get();
        return $arr;
    }

    public function del_receiver(Request $request)
    {
        $rid = $request->input("id");
        SavedReceiver::where("id", $rid)->where("uid", Auth::user()->id)->delete();
    }
}
