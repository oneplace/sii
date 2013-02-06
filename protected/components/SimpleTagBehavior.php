<?php
class SimpleTagBehavior extends CActiveRecordBehavior
{
	public $relationModel;
	public $relationKey;
	
	public function attachTags($tagNames,$removeOldOnes=true)
	{
		if(is_string($tagNames)){
			$tagNames = explode(',',$tagNames);
		}
		foreach($this->owner->tags as $addedTag){
			$i = array_search($addedTag->name,$tagNames);
			if($i!==false){
				unset($tagNames[$i]);
			}else{
				if($removeOldOnes) $this->removeTag($addedTag);
			}
		}
		foreach ($tagNames as $tagName) {
			if(!$tagName) continue;
			$this->owner->addTag($tagName);
		}
	}
	
	public function addTag($tag)
	{
		if(is_string($tag)) $tag = Tag::getByName($tag);
		$tagging = new $this->relationModel;
		$tagging->tagID = $tag->id;
		$tagging->{$this->relationKey} = $this->owner->id;
		return $tagging->save();
	}
	
	public function removeTag($tag)
	{
		if(is_string($tag)){
			$tag = Tag::getByName($tag);
			if(!$tag) return false;
		} 
		$tagID = $tag->id;
		$relationModel = $this->relationModel;
		$relationModel::model()->deleteAllByAttributes(array('tagID'=>$tagID,$this->relationKey=>$this->owner->id));
	}

	public function getTagNames($conditions=array())
	{
		$tagNames = array();
		foreach ($this->owner->tags($conditions) as $tag) {
			$tagNames[]=$tag->name;
		}
		return $tagNames;
	}
}
