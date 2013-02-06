<?php
class MessageController extends Controller
{
	public $layout = '//layouts/iframe';
	
	public function actionIndex()
	{
		$contacts = Conversation::contactWith(user()->id);
		// var_dump($contacts);
		$this->render('index',compact('contacts'));
	}

	public function actionSend($id)
	{
		$user = getOr404('User',$id);
		$message = new Message;
		if(isset($_POST['Message']['content'])){
			$message->content = $_POST['Message']['content'];
			$message->toID = $user->id;
			$message->fromID = user()->id;
			if($message->save()){
				Conversation::record($message->fromID,$message->toID);
				$this->refresh();
			}
		}
		$messages = Message::between(user()->id,$id);
		Message::markAsRead($id,user()->id);
		$this->render('send',compact('user','message','messages'));
	}

	public function actionTest()
	{
		print_r(Message::allNew(user()->id));
	}
}
