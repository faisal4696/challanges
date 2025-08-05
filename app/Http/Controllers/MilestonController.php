<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mileston;
use App\Models\MilestonsComment;
use App\Models\MilestonsLike;
use App\Models\MilestonsReply;
use Illuminate\Support\Facades\Auth;
use Validator;

class MilestonController extends Controller
{
    private $auth;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
        $this->auth = Auth::user();
        return $next($request);
        });
    }

    public function addmileston(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'challange_id' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['status'=>false,'addmileston'=>$validator->errors()]);
        }else{
            $inputs = $request->all();
            $inputs['user_id'] = Auth::user()->id;
            $addmileston = Mileston::create($inputs);
            if($addmileston){
                return response()->json(['status'=>true,'addmileston'=>$addmileston]);
            }else{
                return response()->json(['status'=>false,'addmileston'=>'something error try agian later']);
            }
        }
    }

    public function deletemileston($id)
    {
        $mileston = Mileston::find($id);
        $delete = $mileston->delete();
        if($delete){
            return response()->json(['status'=>true,'deletemileston'=>'mileston delete successfully!']);
        }else{
            return response()->json(['status'=>flase,'deletemileston'=>'something error try agian later']);
        }
    }

    public function updatemileston(Request $request, Mileston $mileston)
    {
        if($mileston->user_id == $this->auth->id && $mileston->id == $request->mileston_id){
            $mileston->update($request->all());
            if($mileston){
                return response()->json(['status'=>true,'updatemileston'=>$mileston]);
            }else{
                return response()->json(['status'=>false,'updatemileston'=>'something error try agian later']);
            }
        }else{
            return redirect()->route('login');
        }
    }

    public function addmilestoncomment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'challange_id' => 'required',
            'mileston_id' => 'required',
            'description' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['status'=>false,'addmilestoncomment'=>$validator->errors()]);
        }else{
            $inputs = $request->all();
            $inputs['user_id'] = Auth::user()->id;
            $addmilestoncomment = MilestonsComment::create($inputs);
            if($addmilestoncomment){
                return response()->json(['status'=>true,'addmilestoncomment'=>$addmilestoncomment]);
            }else{
                return response()->json(['status'=>false,'addmilestoncomment'=>'something error try agian later']);
            }
        }
    }

    public function milestonlike(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mileston_id' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['status'=>false,'milestonlike'=>$validator->errors()]);
        }else{
            $checklike = MilestonsLike::where('user_id',Auth::user()->id)->where('mileston_id',$request->mileston_id)->first();
            if($checklike != null){
                $checklike->delete();
                return response()->json(['status'=>true,'milestonlike'=>'unlike']);
            }else{
                $inputs = $request->all();
                $inputs['user_id'] = Auth::user()->id;
                $addmilestonlike = MilestonsLike::create($inputs);
                if($addmilestonlike){
                    return response()->json(['status'=>true,'milestonlike'=>'like']);
                }else{
                    return response()->json(['status'=>true,'milestonlike'=>'something error try agian later']);   
                }
            }
        }
    }

    public function addmilestonreply(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mileston_id' => 'required',
            'milestons_comment_id' => 'required',
            'description' => 'required',
        ]);	
        if($validator->fails()){
            return response()->json(['status'=>false,'milestonreply'=>$validator->errors()]);
        }else{
            $inputs = $request->all();
            $inputs['user_id'] = Auth::user()->id;
            $addmilestonreply = MilestonsReply::create($inputs);
            if($addmilestonreply){
                return response()->json(['status'=>true,'milestonreply'=>$addmilestonreply]);
            }else{
                return response()->json(['status'=>true,'milestonreply'=>'something error try agian later']);   
            }
        }
    }
}
