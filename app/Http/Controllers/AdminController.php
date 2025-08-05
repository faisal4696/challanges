<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Challange;
use App\Models\Mileston;
use Validator;
use Storage;
use Auth;
use App\Models\User;
use Session;

class AdminController extends Controller
{
    // private $user,$categories;
    // public function __construct(User $user , Category $categories){
    //     $this->user = $user;
    //     $this->categories = $categories;
    // }
    public function index()
    {
        // $users = $this->user->all();
        // $categories = $this->categories->all();
        // dd($users,$categories);
        if(Auth::check() && Auth::user()->role == '1'){
           return view('admin.dashboard');
        }else{
            return redirect()->route('admin.signin');
        }
    }

    public function signin()
    {
        return view('admin.signin');
    }

    public function adminsignin(Request $request)
    {   

        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->except(['_token']);
        $user = User::where('email',$request->email)->where('role','1')->first();
        if (Auth()->attempt($credentials) && Auth()->user()->role == '1') {
            // Session::put('admin',$user);
            return redirect()->route('adminpannel');
        }else{
            Session()->flash('error', 'Invalid credentials');
            return redirect()->back();
        }
    }

    public function categories()
    {
        $categories = Category::all();
        return view('admin.categories',compact('categories'));
    }

    public function addcategory(Request $request)
    {
    	$validator = validator::make($request->all(),[
    		'name' => 'required',
            'file' => 'required|image|mimes:jpeg,png,jpg',
    	]);

    	if($validator->fails()){
            Session()->flash('error','file not in jpg,jpeg,png');
            return back();
    	}else{
    		$filename = time().$request->file('file')->getClientOriginalName();
            Storage::disk('publicdisk')->put($filename, file_get_contents($request->file('file')->getRealPath()));
    		$inputs = $request->all();
    		$inputs['image'] = $filename;
    		$newCategory = Category::Create($inputs);
    		if($newCategory){
                Session()->flash('success','New Category Add Successfully');
                return back();
    		}else{
                Session()->flash('error','something wrong try agian later');
                return back();
    		}
    	}
    }

    public function deletecategory($id)
    {
    	$category = Category::where('id',$id)->first();
    	if($category->delete()){
            Session()->flash('success','Category Delete Successfully!');
            return back();
    	}else{
            Session()->flash('error','something wrong try again later');
            return back();
    	}
    }

    public function updatecategory(Request $request)
    {
        $category = Category::where('id',$request->cat_id)->first();
        if($request->name != null){
            $category->name = $request->name;
        }
        if($request->hasFile('file') != null){
            $validator = validator::make($request->all(),[
            'file' => 'image|mimes:jpeg,png,jpg',
            ]);
            if($validator->fails()){
                Session()->flash('error','file not in jpg,jpeg,png');
                return back();
            }else{
                $filename = time().$request->file('file')->getClientOriginalName();
                Storage::disk('publicdisk')->put($filename, file_get_contents($request->file('file')->getRealPath()));
                $category->image = $filename;
            }
        }
        if($category->save()){
            Session()->flash('success','Category Update Successfully!');
            return back();
        }else{
            Session()->flash('error','something wrong try again later');
            return back();
        }
    }

    public function allusers()
    {
        $users = User::where('role','0')->get();
        return view('admin.allusers',compact('users'));
    }

    public function deleteuser($id)
    {
        $user = User::find($id);
        $delete = $user->delete();
        if($delete){
            session()->flash('success','user delete successfully!');
            return back();
        }else{
            session()->flash('error','something wrong try agian later');
            return back();
        }
    }

    public function updateuser(Request $request)
    {
        $user = User::find($request->user_id);
        if($request->name != null){
            $user->name = $request->name;
        }
        if($request->hasFile('file') != null){
            $validator = validator::make($request->all(),[
            'file' => 'image|mimes:jpeg,png,jpg',
            ]);
            if($validator->fails()){
                Session()->flash('error','file not in jpg,jpeg,png');
                return back();
            }else{
                $filename = time().$request->file('file')->getClientOriginalName();
                Storage::disk('publicdisk')->put($filename, file_get_contents($request->file('file')->getRealPath()));
                $user->image = $filename;
            }
        }
        $edit = $user->save();
        if($edit){
            session()->flash('success','Record Edit Successfully!');
            return back();
        }else{
            session()->flash('error','something error try again later');
            return back();
        }
    }

    public function challanges()
    {
        $challanges = Challange::with('user','category')->get();
        return view('admin.challanges',compact('challanges'));
    }

    public function deletechallange($challange)
    {
        return $challange;
    }

    public function updatechallange(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
        ]);
        if($validator->fails()){
            Session::flash('error','title and description filed is must required...');
            return back();
        }else{
            $formdata = $request->all();
            $data = $request->except('challange_id','_token');
            $updateChallange = Challange::where('id',$formdata['challange_id'])->update($data);
            if($updateChallange){
                Session::flash('success','Challange Update Successfully!');
                return back();
            }else{
                Session::flash('error','Something Error Try Again Later...');
                return back();
            }
        }
    }

    public function viewmilestons($challange)
    {
        $milestons = Mileston::where('challange_id',$challange)->with('challange')->get();
        return view('admin.mileston',compact('milestons'));
    }

    public function updatemileston(Request $request)
    {
        $formdata = $request->all();
        $data = $request->except('mileston_id','_token');
        $updateMileston = Mileston::where('id',$formdata['mileston_id'])->update($data);
        if($updateMileston){
            Session::flash('success','Mileston Update Successfully!');
            return back();
        }else{
            Session::flash('error','Something Failed Try Again Later...');
            return back();
        }
    }

    public function deletemileston($mileston)
    {
        return $mileston;
    }
    
    public function adminlogout()
    {
        // Session::forget('admin');
        Auth::logout();
        request()->session()->flash('success','Logout successfully');
        return redirect()->route('admin.signin');
    }
}
