<?php


namespace App\Presenters;


use App\Forms\FormFactory;
use App\Model\DbMessageStorage;
use App\Model\FileMessageStorage;
use App\Model\IMessageStorage;
use App\Model\MessageGenerator;

class FeedPresenter extends BasePresenter
{

	/** @var  IMessageStorage @inject */
	public $messageStorage;

	/** @var  FormFactory @inject */
	public $formFactory;

	public function renderDefault()
	{
		$this->template->messages = $this->messageStorage->getMessages();
		$this->redrawControl('feed');
	}

	public function createComponentPostForm()
	{
		$form = $this->formFactory->create();
		$form->addHidden('email')
			->setRequired();
		$form->addText('text')
			->setRequired();

		$form->addSubmit('submit');

		$form->onSuccess[] = function($form, $values) {
			$this->messageStorage->postMessage($values->email, $values->text);
			$this->redirect('this');
		};

		return $form;
	}

}
