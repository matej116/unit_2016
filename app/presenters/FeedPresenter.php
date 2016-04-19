<?php


namespace App\Presenters;


use App\Model\FileMessageStorage;
use App\Model\IMessageStorage;

class FeedPresenter extends BasePresenter
{

	/** @var  IMessageStorage @inject */
	public $messageStorage;

	public function renderDefault()
	{
		$this->messageStorage->postMessage('test@test.cz', 'Message text');

		$this->template->messages = $this->messageStorage->getMessages();
	}

}
