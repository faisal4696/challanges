<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class NotifyController extends Controller
{
    public function notifications(Request $request)
    {
    	$search = $request->search;
    	$notifyArray = [];
    	switch ($search) {
    		case 'today':
    			$notifications = Notification::where('user_id',Auth::user()->id)->whereDate('created_at', Carbon::today())->orderBy('id','DESC')->get();
    			array_push($notifyArray, $notifications);
    			break;
    		
    		case 'yesterday':
    			$notifications = Notification::where('user_id',Auth::user()->id)->whereDate('created_at','=', Carbon::yesterday())->orderBy('id','DESC')->get();
    				array_push($notifyArray, $notifications);
    			break;
    		
    		case 'this-week':
    			$notifications = Notification::where('user_id',Auth::user()->id)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->orderBy('id','DESC')->get();
    				array_push($notifyArray, $notifications);
    			break;
    		
    		default:
    			$notifications = Notification::where('user_id',Auth::user()->id)->orderBy('id','DESC')->get();
    			array_push($notifyArray, $notifications);
    			break;
    	}
    	return response()->json(['status'=>true,'notifications'=>$notifyArray]);
    }
}
