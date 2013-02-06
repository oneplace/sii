<?php

class FileuploadController extends CController
{
	public function actionAvatar()
	{
		$file = $this->getImageFile('Filedata');
		$thumb=Yii::app()->phpThumb->create($file->tempName);
		$thumb->adaptiveResize(180,180);
		$newFilename = uniqid().'.'.$file->extensionName;
		$newFilepath = 'upload/avatar/'.$newFilename;
		if($thumb->save($newFilepath)){
			$thumb->adaptiveResize(50,50);
			$thumb->save('upload/small_avatar/'.$newFilename);
			echo CHtml::image('/'.$newFilepath).CHtml::hiddenField('User[avatar]',$newFilename);
		}
	}

	public function actionEditor()
	{
		$file = $this->getImageFile('file');
		$newFile = $this->saveFile($file);
		echo json_encode(array('filelink'=>'/'.$newFile));
	}

	public function getImageFile($name)
	{
		$file = CUploadedFile::getInstanceByName($name);
		if(!$file) 
			throw new CHttpException(400,'no image uploaded');
		$type = CFileHelper::getMimeType($file->getTempName());
		if(strpos($type,'image')===FALSE) 
			throw new CHttpException(400,'no image uploaded');
		return $file;
	}

	public function saveFile($file)
	{
		$uploadDir = 'upload/'.date('Ym').'/';
		if(!file_exists($uploadDir)){
			mkdir($uploadDir,0755);
		}
		$newFile = $uploadDir.uniqid().'.'.$file->extensionName;
		$file->saveAs($newFile);
		return $newFile;
	}

	public function actionTest()
	{
		echo $this->randomFilename();
	}
}
