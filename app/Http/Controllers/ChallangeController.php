<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Challange;
use App\Models\ChallangesComment;
use App\Models\ChallangesLike;
use App\Models\ChallangesReply;
use App\Models\Mileston;
use Illuminate\Support\Facades\Auth;
use Validator;
use Storage;
use URL;

class ChallangeController extends Controller
{
    public function addchallange(Request $request)
    {
        // return $request->all();
    	$validator = Validator::make($request->all(),[
    		'category_id' => 'required',
    		'title' => 'required',
    		'description' => 'required',
    	]);

    	if($validator->fails()){
    		return response()->json(['status'=>false,'addchallange'=>$validator->errors()]);
    	}
    	$inputs = $request->all();
        $inputs['user_id'] = Auth::user()->id;
        // dd($inputs);
    	$newChallange = Challange::create($inputs);
    	if($newChallange){
            if($request->miles_array != null){
                foreach($request->miles_array as $val) {
                   $mileston = Mileston::create([
                    'user_id' => $newChallange->user_id,
                    'challange_id' => $newChallange->id,
                    'title' => $val->title,
                    'decsription' => $val->description,
                   ]);
                }
            }
            $challange = Challange::where('id',$newChallange->id)->with('mileston')->first();
    		return response()->json(['ststus'=>true,'addchallange'=>$challange]);
    	}else{
    		return response()->json(['status'=>false,'addchallange'=>'failed']);
    	}
    }

    public function searchchallange(Request $request)
    {
        $challange = Challange::where('title', 'like', '%'.$request->title.'%')->get();
        if(!$challange->isEmpty()){
            return response()->json(['status'=>true,'challange'=>$challange]);
        }else{
            return response()->json(['status'=>false,'challange'=>'not found']);
        }
    }

    public function deletechallange(Challange $challange)
    {
        $del_challange = Challange::find($challange);
    	$delete = $del_challange->delete();
    	if($delete){
    		return response()->json(['status'=>true,'deletechallange'=>'challange delete successfully']);
    	}else{
    		return response()->json(['status'=>false,'deletechallange'=>'failed']);
    	}
    }

    public function updatechallange(Request $request, Challange $challange)
    {
    	// dd($challange);
    	$challange->update($request->all());
    	if($challange){
    		return response()->json(['status'=>true,'updatechallange'=>$challange]);
    	}else{
    		return response()->json(['status'=>false,'updatechallange'=>'failed']);
    	}
    }

    public function mychallanges($challange)
    {
    	$mychallanges = Challange::where('user_id',$challange)->paginate(4);
    	if($mychallanges != null){
    		return response()->json(['status'=>true,'mychallanges'=>$mychallanges]);
    	}else{
    		return response()->json(['status'=>flase,'mychallanges'=>'empty']);
    	}
    }

    public function getchallange($challange)
    {
        $challange = Challange::where('id',$challange)->with('challangeComment','challangeComment.user','challangeComment.challangeReply')->first();
        return response()->json(['status'=>true,'challange'=>$challange]);
    }

    public function allchallanges()
    {
    	$allchallanges = Challange::with('user')->withCount('challangeComment')->paginate(4);
    	return response()->json(['status'=>true,'allchallanges'=>$allchallanges]);
    }

    public function addchallangecomment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'challange_id' => 'required',
            'description' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['status'=>false,'challangecomment'=>$validator->errors()]);
        }else{
            // $basepath = URL::to('/');
            $inputs = $request->all();
            $inputs['user_id'] = Auth::user()->id;
            $inputs['time'] = date("h:i:sa");
            if($request->hasFile('attachment')){
                $filename = time().$request->file('attachment')->getClientOriginalName();
                Storage::disk('publicdisk')->put($filename, file_get_contents($request->file('attachment')->getRealPath()));
                // $basepath = 'http://192.168.10.3:8000/uploads/images/';
                $inputs['attachment'] = $filename;
            }
            $challangecomment = ChallangesComment::create($inputs);
            if($challangecomment){
                return response()->json(['status'=>true,'challangecomment'=>$challangecomment]);
            }else{
                return response()->json(['status'=>false,'challangecomment'=>'something error try again later']);
            }
        }
    }

    public function challangelike(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'challange_id' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['status'=>false,'challangelike'=>$validator->errors()]);
        }else{
            $checklike = ChallangesLike::where('user_id',Auth::user()->id)->where('challange_id',$request->challange_id)->first();
            if($checklike != null){
                $checklike->delete();
                return response()->json(['status'=>true,'challangelike'=>'unlike']);
            }else{
                $inputs = $request->all();
                $inputs['user_id'] = Auth::user()->id;
                $newchallangelike = ChallangesLike::create($inputs);
                if($newchallangelike){
                    return response()->json(['status'=>true,'challangelike'=>'like']);
                }else{
                    return response()->json(['status'=>false,'challangelike'=>'something error try again later']);
                }
            }
        }
    }

    public function addchallangereply(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'challange_id' => 'required',
            'challanges_comment_id' => 'required',
            'description' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['status'=>false,'challangereply'=>$validator->errors()]);
        }else{
            $inputs = $request->all();
            $inputs['user_id'] = Auth::user()->id;
            $challangereply = ChallangesReply::create($inputs);
            if($challangereply){
                return response()->json(['status'=>true,'challangereply'=>$challangereply]);
            }else{
                return reponse()->json(['status'=>false,'challangereply'=>'something error try again later']);
            }
        }
    }
}
