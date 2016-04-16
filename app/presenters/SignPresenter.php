<?php

namespace App\Presenters;

use App\Forms\FormFactory;
use App\Model\UserManager;
use Nette;
use App\Forms\SignFormFactory;


class SignPresenter extends BasePresenter
{
	/** @var SignFormFactory @inject */
	public $signFormFactory;

	/** @var FormFactory @inject */
	public $formFactory;

	/** @var  UserManager @inject */
	public $userManager;


	/**
	 * Sign-in form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignInForm()
	{
		$form = $this->signFormFactory->create();
		$form->onSuccess[] = function ($form) {
			$form->getPresenter()->redirect('Homepage:');
		};
		return $form;
	}


	public function actionOut()
	{
		$this->getUser()->logout();
	}

	public function createComponentRegisterForm()
	{
		$form = $this->formFactory->create();
		$form->addText('username', "Username");
		$form->addPassword('password', "Password");

		$form->addSubmit('submit');

		$form->onSuccess[] = function($form, $values) {
			$this->userManager->add($values->username, $values->password);
			$this->flashMessage('Registered');
			$this->redirect('in');
		};

		return $form;
	}

}
