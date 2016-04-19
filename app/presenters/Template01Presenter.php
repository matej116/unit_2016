<?php
/**
 * Created by PhpStorm.
 * User: ducan
 * Date: 18.04.2016
 * Time: 0:22
 */

namespace App\Presenters;

use App\Forms\FormFactory;
use App\Model\IMessageStorage;

class Template01Presenter extends BasePresenter
{
	/** @var FormFactory @inject */
	public $formFactory;

	/**
	 * @var IMessageStorage @inject
	 */
	public $messageStorage;

	protected function createComponentPostForm()
	{
		$form = $this->formFactory->create();

		$form->addText('email')
			->setRequired();
		$form->addTextArea('text')
			->setRequired();

		$form->addSubmit('submit');

		$form->onSuccess[] = function($form, $values) {
			$this->messageStorage->postMessage($values->email, $values->text);
			$this->redirect('this');
		};

		return $form;
	}

	public function renderHome()
	{

		$items = ['franta', 'kuzmic', 'matej'];

		$this->template->items = $items;

	}

	public function renderFeed()
	{
		$this->template->messages = $this->messageStorage->getMessages();
	}


}
