<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ValidationRules;
use Validator;
use Auth;
use App\Template;
use App\Telegram;
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
            if (isset($data["password"])) $data['password'] = bcrypt($data['password']);
            $user->update($data);
            // $user->user_type = $data['user_type'];
            // $user->fio = $data['fio'];
            // $user->company = $data['company'];
            // $user->phone = $data['phone'];
            // $user->region = $data['region'];
            // $user->city = $data['city'];
            // $user->street = $data['street'];
            // $user->building = $data['building'];
            // $user->flat = $data['flat'];
            // $user->save();
        }
        return view('home.profile');
    }


    public function history()
    {
        return view('home.history');
    }

    public function get_history()
    {
        $user = Auth::user();
        $arr = Telegram::where("uid", $user->id)->get();
        return $arr;
    }


    public function templates(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $data["uid"] = Auth::user()->id;
            if (isset($data["current_id"])) Template::find($data["current_id"])->update($data);
            else Template::create($data);
            return redirect()->back();
        }
        return view('home.templates');
    }
    public function get_templates()
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
            $data = $request->all();
            $data["uid"] = Auth::user()->id;
            if (isset($data["current_id"])) SavedReceiver::find($data["current_id"])->update($data);
            else SavedReceiver::create($data);
            return redirect()->back();
        }
        return view('home.saved_receivers');
    }

    public function get_receivers()
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
