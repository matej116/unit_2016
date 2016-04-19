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

  protected function createComponentForm()
  {
    $form = $this->formFactory->create();
    $form->addText('test_text1', 'Test text 1:');
      $form->addText('test_text2', 'Test text 2:');
      $form->addText('test_text3', 'Test text 3:');
      $form->addSubmit('send', 'Send:');
    return $form;
  }

    public function renderHome() {

        $items = ['franta', 'kuzmic', 'matej'];

        $this->template->items = $items;

    }

    public function renderFeed()
    {
      $this->template->messages = $this->messageStorage->getMessages();
    }


}
