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
		$this->template->userEmail = $this->getParameter('email');
		$this->redrawControl('feed');
	}

	public function createComponentPostForm()
	{
		$form = $this->formFactory->create();
		$form->addText('email')
			->setRequired()
			->setDefaultValue($this->getParameter('email'));
		$form->addText('text')
			->setDefaultValue('');

		$form->addSubmit('submit', 'Odeslat');

		$form->onSuccess[] = function($form, $values) {
			if ($values->text && $values->email) {
				$this->messageStorage->postMessage($values->email, $values->text);
			}
		};

		$form->onSubmit[] = function($form) {
			$this->redirect('this', ['email' => $form->values->email]);
		};


		return $form;
	}

	public function handleAme($id, $email = 'noone')
	{
		$this->messageStorage->vote($email, $id);
		$this->sendPayload();
	}

}
