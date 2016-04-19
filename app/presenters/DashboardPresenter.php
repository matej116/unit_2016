<?php


namespace App\Presenters;

use App\Model\DbMessageStorage;

class DashboardPresenter extends BasePresenter
{
	/** @var  DbMessageStorage @inject */
	public $messageStorage;

	public function renderDefault()
	{
		$this->template->dailyStats = $this->messageStorage->countDay();
		$this->template->totalMsgCount = $this->messageStorage->totalCount();
		$this->template->top10Messages = $this->messageStorage->topTenMessagesPerDay();
		$this->template->top10People = $this->messageStorage->topTenPeoplePerDay();
		$this->template->newMessages = $this->messageStorage->getMessages();
		$this->redrawControl('dashboard');
	}

}
