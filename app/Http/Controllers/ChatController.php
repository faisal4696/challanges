<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat;
use App\Models\User;
use App\Models\Notification;
use App\Events\SendMessageEvent;
use Validator;
use Storage;
use URL;
use Carbon\Carbon;
use DateTime;

class ChatController extends Controller
{

    private function sendNotification($a, $message, $data)
    {
        $content = array(
                         "en" => $message
                         );
        
        $fields = array(
                        // 'app_id' => "",
                        // 'include_player_ids' => [$a],
                        'registration_ids' => [$a],
                        'data' => array(
                        				'click_action' => "FLUTTER_NOTIFICATION_CLICK",
                        				'data' => $data
                        			),
                        'contents' => $content,
                        'notification' => array ( "title" => $message, "body" => $message, "data" => $data ),
                        );

        $headers = array (
            			'Authorization: key=' . "AAAACraBZNM:APA91bGoEpRsA7m71CMRLfAi_M9VQyuWvlCyDIPzkyceatHDH-8nbaeMwlG8lJrgBQK9sK-5igiHvMkcl0YUaiX0P0FjqqcTHTXrGFQbWf4Ld5Oon7FYvll-I45i89XRyGEL31feHaNa",
            			'Content-Type: application/json'
    					);
        
        $fields = json_encode($fields);

        $url = 'https://fcm.googleapis.com/fcm/send';
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        // curl_setopt($ch, CURLOPT_HEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        return $response;
    }

	public function conversation(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'user_id' => 'required',
		]);
		if($validator->fails()){
			return response()->json(['status'=>false,'conversation'=>$validator->errors()]);
		}else{
			$conversation = Conversation::where([
				[ 'sender_id', '=', $request->user_id ] , [ 'receiver_id', '=', Auth::user()->id ] 
			])->orWhere([
				[ 'sender_id', '=', Auth::user()->id ] , [ 'receiver_id', '=', $request->user_id ] 
				])->first();
			$chatArray = [];
			if($conversation != null){
				$chats = Chat::where('conversation_id',$conversation->id)->withTrashed()->get();
				if($conversation->sender_id == Auth::user()->id){
					$receiver = User::where('id',$conversation->receiver_id)->select('id','name','image','status','last_seen')->first();
				}else{
					$receiver = User::where('id',$conversation->sender_id)->select('id','name','image','status','last_seen')->first();
				}
				$conversation['receiver'] = $receiver;
				foreach ($chats as $val1) {
					$show = $val1->deleted_by;
					if($show == null){
						array_push($chatArray, $val1);
					}else{
						switch ($show) {
						case 0:
							if(Auth::user()->id == $val1->sender_id){ }else{ array_push($chatArray, $val1); }
							break;
						case 1:
							if(Auth::user()->id == $val1->receiver_id){ }else{ array_push($chatArray, $val1); }
							break;
						case 2:
							
							break;
						default:
							array_push($chatArray, $val1);
							break;
						}
					}
				}
				$conversation['chat'] = $chatArray;
				return response()->json(['status'=>true,'conversation'=>$conversation]);
			}else{
				$inputs = $request->all();
				$inputs['sender_id'] = Auth::user()->id;
				$inputs['receiver_id'] = $request->user_id;
				$newConversation = Conversation::create($inputs);
				$getconversation = Conversation::where('id',$newConversation->id)->first();
				if($getconversation->sender_id == Auth::user()->id){
					$receiver = User::where('id',$getconversation->receiver_id)->select('id','name','image','status','last_seen')->first();
					if($receiver->last_seen != null){
						$carbon_last_seen = $this->timeago(date($receiver->last_seen));
						$receiver['last_seen'] = $carbon_last_seen;
					}
				}else{
					$receiver = User::where('id',$getconversation->sender_id)->select('id','name','image','status','last_seen')->first();
					if($receiver->last_seen != null){
						$carbon_last_seen = $this->timeago(date($receiver->last_seen));
						$receiver['last_seen'] = $carbon_last_seen;
					}
				}
				$getconversation['receiver'] = $receiver;
				$chatArray = [];
				$chats = Chat::where('id',$getconversation->id)->withTrashed()->get();
				foreach ($chats as $val) {
					$show = $val->deleted_by;
					if($show == null){
						array_push($chatArray, $val1);
					}else{
						switch ($show) {
							case 0:
								if(Auth::user()->id == $val->sender_id){ }else{ array_push($chatArray, $val1); }
								break;
							case 1:
								if(Auth::user()->id == $val->receiver_id){ }else{ array_push($chatArray, $val1); }
								break;
							case 2:

								break;
							default:
								array_push($chatArray, $val1);
								break;
						}
					}
				}
				$getconversation['chat'] = $chatArray;
				return response()->json(['status'=>true,'conversation'=>$getconversation]);
			}
		}
	}

	public function allconversations()
	{
		$uid = Auth::user()->id;
		$newArray = [];
		$allconversations = Conversation::where('sender_id',$uid)->orwhere('receiver_id',$uid)->orderBy('updated_at', 'desc')->withTrashed()->get();

		foreach ($allconversations as $val) {
			$show = $val->deleted_by;
			if($show == null){
				$id = $val->id;
				$sender_id = $val->sender_id;
				$receiver_id = $val->receiver_id;
				$created_at = $val->created_at;
				$lastmessage = Chat::where('conversation_id',$val->id)->orderBy('id', 'DESC')->first();
				if($val->sender_id == $uid){
					$receiver = User::where('id',$receiver_id)->select('id','name','image','status','last_seen')->first();
					if($receiver->last_seen != null){
						$carbon_last_seen = $this->timeago(date($receiver->last_seen));
						$receiver['last_seen'] = $carbon_last_seen;
					}
				}else{
					$receiver = User::where('id',$sender_id)->select('id','name','image','status','last_seen')->first();
					if($receiver->last_seen != null){
						$carbon_last_seen = $this->timeago(date($receiver->last_seen));
						$receiver['last_seen'] = $carbon_last_seen;
					}
				}
				if($lastmessage){
					$data = array('id'=>$id,'sender_id'=>$sender_id,'receiver_id'=>$receiver_id,'created_at'=>$created_at,'lastmsg'=>$lastmessage,'receiver'=>$receiver);
					array_push($newArray,$data);
				}
			}else{
			switch ($show) {
			  case 0:
			  	if(Auth::user()->id == $val->sender_id){

			  	}else{
			  		$id = $val->id;
					$sender_id = $val->sender_id;
					$receiver_id = $val->receiver_id;
					$created_at = $val->created_at;
					$lastmessage = Chat::where('conversation_id',$val->id)->orderBy('created_at', 'DESC')->first();
					if($val->sender_id == $uid){
						$receiver = User::where('id',$receiver_id)->select('id','name','image','status','last_seen')->first();
						if($receiver->last_seen != null){
							$carbon_last_seen = $this->timeago(date($receiver->last_seen));
							$receiver['last_seen'] = $carbon_last_seen;
						}
					}else{
						$receiver = User::where('id',$sender_id)->select('id','name','image','status','last_seen')->first();
						if($receiver->last_seen != null){
							$carbon_last_seen = $this->timeago(date($receiver->last_seen));
							$receiver['last_seen'] = $carbon_last_seen;
						}
					}
					if($lastmessage){
						$data = array('id'=>$id,'sender_id'=>$sender_id,'receiver_id'=>$receiver_id,'created_at'=>$created_at,'lastmsg'=>$lastmessage,'receiver'=>$receiver);
						array_push($newArray,$data);
					}
			  	}
			  	break;
			  case 1:
			    if(Auth::user()->id == $val->receiver_id)
			  	{
			  		
			  	}else{
				  	$id = $val->id;
					$sender_id = $val->sender_id;
					$receiver_id = $val->receiver_id;
					$created_at = $val->created_at;
					$lastmessage = Chat::where('conversation_id',$val->id)->orderBy('created_at', 'DESC')->first();
					if($val->sender_id == $uid){
						$receiver = User::where('id',$receiver_id)->select('id','name','image','status','last_seen')->first();
						if($receiver->last_seen != null){
							$carbon_last_seen = $this->timeago(date($receiver->last_seen));
							$receiver['last_seen'] = $carbon_last_seen;
						}
					}else{
						$receiver = User::where('id',$sender_id)->select('id','name','image','status','last_seen')->first();
						if($receiver->last_seen != null){
							$carbon_last_seen = $this->timeago(date($receiver->last_seen));
							$receiver['last_seen'] = $carbon_last_seen;
						}
					}
					if($lastmessage){
						$data = array('id'=>$id,'sender_id'=>$sender_id,'receiver_id'=>$receiver_id,'created_at'=>$created_at,'lastmsg'=>$lastmessage,'receiver'=>$receiver);
						array_push($newArray,$data);
					}
			  	}
			    break;
			  case 2:
			    break;
			  default:
			   $id = $val->id;
				$sender_id = $val->sender_id;
				$receiver_id = $val->receiver_id;
				$created_at = $val->created_at;
				$lastmessage = Chat::where('conversation_id',$val->id)->orderBy('created_at', 'DESC')->first();
				if($val->sender_id == $uid){
					$receiver = User::where('id',$receiver_id)->select('id','name','image','status','last_seen')->first();
					if($receiver->last_seen != null){
						$carbon_last_seen = $this->timeago(date($receiver->last_seen));
						$receiver['last_seen'] = $carbon_last_seen;
					}
				}else{
					$receiver = User::where('id',$sender_id)->select('id','name','image','status','last_seen')->first();
					if($receiver->last_seen != null){
						$carbon_last_seen = $this->timeago(date($receiver->last_seen));
						$receiver['last_seen'] = $carbon_last_seen;
					}
				}
				if($lastmessage){
					$data = array('id'=>$id,'sender_id'=>$sender_id,'receiver_id'=>$receiver_id,'created_at'=>$created_at,'lastmsg'=>$lastmessage,'receiver'=>$receiver);
					array_push($newArray,$data);
				}
				break;
			}
		}
		}

		// foreach ($newArray as $sort) {
		// 	return $sort['lastmsg']->created_at;
		// }
		return response()->json(['status'=>true,'allconversations'=>$newArray]);
	}

	public function timeago($time, $tense='ago') {
		// declaring periods as static function var for future use
		static $periods = array('year', 'month', 'day', 'hour', 'minute', 'second');
	
		// checking time format
		if(!(strtotime($time)>0)) {
			return trigger_error("Wrong time format: '$time'", E_USER_ERROR);
		}
	
		// getting diff between now and time
		$now  = new DateTime('now');
		$time = new DateTime($time);
		$diff = $now->diff($time)->format('%y %m %d %h %i %s');
		// combining diff with periods
		$diff = explode(' ', $diff);
		$diff = array_combine($periods, $diff);
		// filtering zero periods from diff
		$diff = array_filter($diff);
		// getting first period and value
		$period = key($diff);
		$value  = current($diff);
	
		// if input time was equal now, value will be 0, so checking it
		if(!$value) {
			$period = 'seconds';
			$value  = 0;
		} else {
			// converting days to weeks
			if($period=='day' && $value>=7) {
				$period = 'week';
				$value  = floor($value/7);
			}
			// adding 's' to period for human readability
			if($value>1) {
				$period .= 's';
			}
		}
	
		// returning timeago
		return "$value $period $tense";
	}

// 	public function myRecursiveFunction($lastmessage) {


//   if ( $lastmessage->message != null ) {
 
//     return $lastmessage;

//   } else {

//     Chat::where('conversation_id',$lastmessage->conversation_id)->where()
//     myRecursiveFunction($lastmessage);
// }
//old code
	// public function getmessages()
	// {
	// 	$uid = Auth::user()->id;
	// 	$messages = Chat::where('sender_id',$uid)->orwhere('receiver_id',$uid)->with('sender','receiver')->get();
	// 	if(!$messages->isEmpty()){
	// 		return response()->json(['status'=>true,'meaages'=>$messages]);
	// 	}else{
	// 		return response()->json(['status'=>false,'message'=>'empty']);
	// 	}
	// }

	// public function sendmessage(Request $request)
	// {	
	// 	$auth_id = Auth::user()->id;
	// 	$url = URL::to('/');
	// 	$path = $url.'/uploads/attachments/';
	// 	$validator = Validator::make($request->all(), [
	// 		'conversation_id' => 'required',
	// 		'user_id' => 'required',
	// 	]);
	// 	if($validator->fails()){
	// 		return response()->json(['status'=>false,'sendmessage'=>$validator->errors()]);
	// 	}else{
	// 		$newMessage = new Chat;
	// 		$newMessage->sender_id = $auth_id;
	// 		$newMessage->receiver_id = $request->user_id;
	// 		$newMessage->message = $request->message;
	// 		$newMessage->conversation_id = $request->conversation_id;
	// 		if($request->hasFile('attachment') != null){
 //                $filename = time().'-'.$request->file('attachment')->getClientOriginalName();
 //                Storage::disk('attachmentdisk')->put($filename, file_get_contents($request->file('attachment')->getRealPath()));
	// 			$newMessage->attachment = $path.$filename;
 //        	}
	// 		if($newMessage->save()){

	// 			$msg = Chat::where('id',$newMessage->id)->first();
	// 			$sender = User::where('id',$msg->sender_id)->first();
	// 			$receiver = User::where('id',$msg->receiver_id)->first();
	// 			$txt = "New Message Receive From " . $sender->name;
	// 			$this->sendNotification($receiver->device_id, $txt, $msg);

	// 			$createNotofication = Notification::create([
	// 				'user_id' => $receiver->id,
	// 				'comment' => $txt,
	// 				'notification_type' => 'message-notification',
	// 				'status' => 'unseen',
	// 			]);
	// 			return response()->json(['status'=>true,'sendmessage'=>$msg]);
	// 		}else{
	// 			return response()->json(['status'=>false,'sendmessage'=>'something failed try again later']);
	// 		}
	// 	}
	// }

	public function getmessages(Request $request)
	{
		$uid = Auth::user()->id;
		$msgArray = [];
		$messages = Chat::where('sender_id',$uid)->orwhere('receiver_id',$uid)->orwhere('conversation_id',$request->conversation_id)->withTrashed()->get();

		foreach ($messages as $val) {
			$show = $val->deleted_by;
			if($show == null){
				$id = $val->id;
				$sender_id = $val->sender_id;
				$receiver_id = $val->receiver_id;
				$message = $val->message;
				$attachment = $val->attachment;
				$created_at = $val->created_at;
				$data = ['id'=>$id,'sender_id'=>$sender_id,'receiver_id'=>$receiver_id,'message'=>$message,'attachment'=>$attachment,'created_at'=>$created_at];
				array_push($msgArray, $data);

			}else{

			switch ($show) {
				case 0:
				if(Auth::user()->id == $val->sender_id){

				}else{
					$id = $val->id;
					$sender_id = $val->sender_id;
					$receiver_id = $val->receiver_id;
					$message = $val->message;
					$attachment = $val->attachment;
					$created_at = $val->created_at;
					$data = ['id'=>$id,'sender_id'=>$sender_id,'receiver_id'=>$receiver_id,'message'=>$message,'attachment'=>$attachment,'created_at'=>$created_at];
					array_push($msgArray, $data);
				}
			break;
			  case 1:
			  if(Auth::user()->id == $val->receiver_id){

			  }else{
			  	$id = $val->id;
				$sender_id = $val->sender_id;
				$receiver_id = $val->receiver_id;
				$message = $val->message;
				$attachment = $val->attachment;
				$created_at = $val->created_at;
				$data = ['id'=>$id,'sender_id'=>$sender_id,'receiver_id'=>$receiver_id,'message'=>$message,'attachment'=>$attachment,'created_at'=>$created_at];
				array_push($msgArray, $data);
			  }
			break;
				case 2:
			break;
			default:
				$id = $val->id;
				$sender_id = $val->sender_id;
				$receiver_id = $val->receiver_id;
				$message = $val->message;
				$attachment = $val->attachment;
				$created_at = $val->created_at;
				$data = ['id'=>$id,'sender_id'=>$sender_id,'receiver_id'=>$receiver_id,'message'=>$message,'attachment'=>$attachment,'created_at'=>$created_at];
				array_push($msgArray, $data);
				break;
			}
		}

		}

		if($msgArray){
			return response()->json(['status'=>true,'message'=>$msgArray]);
		}else{
			return response()->json(['status'=>false,'message'=>'empty']);
		}
	}

	public function sendmessage(Request $request)
	{	
		$auth_id = Auth::user()->id;
		$url = URL::to('/');
		$path = $url.'/uploads/attachments/';
		$validator = Validator::make($request->all(), [
			'conversation_id' => 'required',
			'user_id' => 'required',
		]);
		if($validator->fails()){
			return response()->json(['status'=>false,'sendmessage'=>$validator->errors()]);
		}else{
			$newMessage = new Chat;
			$newMessage->sender_id = $auth_id;
			$newMessage->receiver_id = $request->user_id;
			$newMessage->message = $request->message;
			$newMessage->conversation_id = $request->conversation_id;
			if($request->hasFile('attachment') != null){
                $filename = time().'-'.$request->file('attachment')->getClientOriginalName();
                Storage::disk('attachmentdisk')->put($filename, file_get_contents($request->file('attachment')->getRealPath()));
				$newMessage->attachment = $path.$filename;
        	}
			if($newMessage->save()){
				$msg = Chat::where('id',$newMessage->id)->first();
				$sender = User::where('id',$msg->sender_id)->select('id','name','status','last_seen')->first();
				if($sender->last_seen != null){
					$carbon_last_seen = $this->timeago(date($sender->last_seen));
					$sender['last_seen'] = $carbon_last_seen;
				}
				$msg['sender'] = $sender;
				$receiver = User::where('id',$msg->receiver_id)->first();
				$txt = "New Message Receive From " . $sender->name;
				$this->sendNotification($receiver->device_id, $txt, $msg);
			
				$createNotofication = Notification::create([
					'user_id' => $receiver->id,
					'comment' => $txt,
					'notification_type' => 'message-notification',
					'status' => 'unseen',
				]);

				$updateConversation = Conversation::where('id',$request->conversation_id)->first();
				$updateConversation->updated_at = $msg->created_at;
				$updateConversation->save();

				event(new SendMessageEvent($msg));
				return $this->getmessages($request);

				return response()->json(['status'=>true,'sendmessage'=>$msg]);
			}else{
				return response()->json(['status'=>false,'sendmessage'=>'something failed try again later']);
			}
		}
	}

	public function searchperson($person)
	{
		$person = User::where('name', 'like', '%'.$person.'%')->where('id','!=',Auth::user()->id)->select('id','name','image')->get();
		if(!$person->isEmpty()){
			return response()->json(['status'=>true,'person'=>$person]);
		}else{
			return response()->json(['status'=>false,'person'=>'not found']);
		}
	}

	public function deleteconversation(Request $request)
	{
		// return $request->all();
		$data = $request->all();
		foreach ($data as $val) {
			$con = Conversation::where('id',$val)->withTrashed()->first();
			if($con->deleted_by == null){
				if($con->sender_id == Auth::user()->id){
					$con->deleted_by = '0';
				}else{
					$con->deleted_by = '1';
				}
			}else{
				$con->deleted_by = '2';
			}
			if($con->save()){
				$con->delete();
			}
			$chats = Chat::where('conversation_id',$val)->get();
			foreach ($chats as $val1) {
				$chat = Chat::where('id',$val1->id)->withTrashed()->first();
				if($chat->deleted_by == null){
					if($chat->sender_id == Auth::user()->id){
						$chat->deleted_by = '0';
					}else{
						$chat->deleted_by = '1';
					}
				}else{
					$chat->deleted_by = '2';
				}
				if($chat->save()){
					$chat->delete();
				}
			}
		}

		return response()->json(['status'=>true,'response'=>'conversation delete successfully']);
	}

	public function deletemessage(Request $request)
	{
		// return $request->all();
		$data = $request->all();
		foreach ($data as $val) {
			$chats = Chat::where('id',$val)->withTrashed()->first();
			if($chats->deleted_by == NULL){
					if($chats->sender_id == Auth::user()->id){
						$chats->deleted_by = '0';
					}else{
						$chats->deleted_by = '1';
					}
				}else{
					$chats->deleted_by = '2';
				}
				if($chats->save()){
					$chats->delete();
				}
		}
		return response()->json(['status'=>true,'response'=>'message delete successfully']);
	}

}
