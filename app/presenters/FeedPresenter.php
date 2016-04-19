<?php


namespace App\Presenters;


use App\Forms\FormFactory;
use App\Model\DbMessageStorage;
use App\Model\FileMessageStorage;
use App\Model\IMessageStorage;
use App\Model\MessageGenerator;
use Nette\InvalidArgumentException;

class FeedPresenter extends BasePresenter
{

	/** @var  IMessageStorage @inject */
	public $messageStorage;

	/** @var  FormFactory @inject */
	public $formFactory;

	public function renderDefault($sort = 'time')
	{
		if (!in_array($sort, ['time', 'votes'])) {
			throw new InvalidArgumentException;
		}
		$this->template->messages = $this->messageStorage->getMessages(20, $sort);
		$this->template->sort = $sort;
		$this->redrawControl('feed');
	}

	public function createComponentPostForm()
	{
		$form = $this->formFactory->create();
		$form->addText('email')
			->setRequired()
			->setDefaultValue($this->getParameter('email'));
		$form->addText('text')
			->setDefaultValue('')
			->setRequired();

		$form->addSubmit('submit', 'Odeslat');

		$form->onSuccess[] = function($form, $values) {
			$this->messageStorage->postMessage($values->email, $values->text);
			$this->redirect('this', ['email' => $values->email]);
		};

		return $form;
	}

}
