<?php


namespace App\Presenters;

use App\Model\IMessageStorage;

class DashboardPresenter extends BasePresenter
{
	/** @var  IMessageStorage @inject */
	public $messageStorage;

	public function renderDefault()
	{
    $this->template->dailyStats = $this->messageStorage->countDay();
    $this->template->top10Messages = $this->messageStorage->topTenMessagesPerDay();
    $this->template->top10People = $this->messageStorage->topTenPeoplePerDay();
    $this->redrawControl('dailyStats');
    $this->redrawControl('top10Messages');
    $this->redrawControl('top10People');
	}

}
