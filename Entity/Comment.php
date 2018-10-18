<?php

namespace Entity;

class Comment extends Base
{
	protected $date;
	protected $comment;
	
	public function setDate($date)
	{
		$this->date = $date;
	}
	
	public function getDate()
	{
		return $this->date;
	}
	
	public function setComment($comment)
	{
		$this->comment = $comment;
	}
	
	public function getComment()
	{
		return $this->comment;
	}
}
