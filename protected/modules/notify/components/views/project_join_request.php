<?php echo CHtml::link($requester['name'],array('user/view','id'=>$requester['id'])) ?> 
请求加入 项目 <?php echo CHtml::link($project['title'],array('project/view','id'=>$project['id'])) ?> 
申请成为 <?php echo $request['role'] ?><br>
"<?php echo $request['message'] ?>" 
