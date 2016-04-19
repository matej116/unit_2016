<?php


namespace App\Presenters;

use App\Model\IMessageStorage;

class DashboardPresenter extends BasePresenter
{
	/** @var  IMessageStorage @inject */
	public $messageStorage;

	public function renderDefault()
	{

	}

}
