<?php if($this->model->mode=='request'&&$this->model->status!=0): ?>
	<?php echo $this->model->status==1?'已接受':'已拒绝' ?>
<?php else: ?>
<a class="btn btn-mini btn-primary request-accept" rel="notice-<?php echo $this->model->id ?>" href="<?php echo $this->acceptLink() ?>">
<?php echo $this->acceptLabel ?></a>
<a class="btn btn-mini request-reject" rel="notice-<?php echo $this->model->id ?>" href="<?php echo $this->rejectLink() ?>">
<?php echo $this->rejectLabel ?></a>
<?php endif ?>
