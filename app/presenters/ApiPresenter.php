<?php


namespace App\Presenters;


use App\Model\MessageGenerator;
use Nette\Application\Responses\TextResponse;

class ApiPresenter extends BasePresenter
{

	/** @var  MessageGenerator @inject */
	public $generator;

	public function actionGenerate($count = 1)
	{
		$this->generator->something($count);

		$this->sendResponse(new TextResponse('success'));
	}

}
