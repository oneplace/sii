<?php

class NoticeEvents
{
	protected function getListeners()
	{
		return array(
			'Idea.created'=>'ideaCreated',
			'ProjectJoinRequest.created'=>'projectJoinRequest',	
			'IdeaComment.created'=>'test',
		);
	}
	
	public function addListeners()
	{
		foreach ($this->getListeners() as $event => $handler) {
			if(is_string($handler))
				Yii::app()->event->on($event,array($this,$handler));
			elseif(is_array($handler))
				Yii::app()->event->on($event,$handler);
		}
	}

	public function test($comment)
	{
		// echo 'IdeaComment.created';
		// Notification::add($comment->idea->userID,'idea_comment',array('comment'=>$comment,'idea'=>$comment->idea));
	}

	public static function ideaCreated($model)
	{
		// echo 'model saved: '.$model->id;
// 		print_r($model->attributes);
		$notification = new Notification;
		$notification->userID = 1;
		$notification->type = 'idea_created';
		$notification->data = json_encode($notification->attributes);
		$notification->save();
	}

	public static function projectJoinRequest($request,$requester)
	{
		$project = getOr404('Project',$request->projectID);
		Notification::add($project->creatorID,'project_join_request',compact('project','request','requester'),'request');
	}

}
