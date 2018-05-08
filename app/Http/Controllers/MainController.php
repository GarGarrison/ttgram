<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Telegram;
use App\Template;
use App\SavedReceiver;

use App\Libs\Kladr\Api;
use App\Libs\Kladr\Query;
use App\Libs\Kladr\ObjectType;

class MainController extends Controller
{
    public function index(){
        return view('index');
    }

    public function test(){
        return view('test');
    }

    public function info(){
        return view('info');
    }

    public function service(){
        $user = Auth::user();
        $templates = $user ? Template::where("uid", $user->id)->get() : [];
        $receivers = $user ? SavedReceiver::where("uid", $user->id)->get() : [];
        return view('service', ["templates" => $templates, "receivers"=>$receivers]);
    }

    public function save_telegram(Request $request){
        $user = Auth::user();
        $data = $request->all();
        if ($user) $data["uid"] = $user->id;
        $new_telegram = Telegram::create($data);
        return $new_telegram->id;
    }
    // public function get_user_data(){
    //     return Auth::user();
    // }

    public function get_receiver_data($rid){
        return SavedReceiver::find($rid);
    }

    public function get_template_data($tid){
        return Template::find($tid);
    }

    public function kladr(Request $request){
        $value = $request->input("value");
        $type = $request->input("type");
        $parent = $request->input("parent");
        $parent_type = $request->input("parent_type");
        
        $api = new Api('51dfe5d42fb2b43e3300006e', '86a2c2a06f1b2451a87d05512cc2c3edfdf41969');;

        $query = new Query();
        $query->ContentName = $value;
        $query->ContentType = $type;
        $query->ParentType = $parent_type;
        $query->ParentId = $parent;
        $query->WithParent = false;;
        $query->Limit = 5;

        $arResult = $api->QueryToArray($query);
        return $arResult;
    }
}
