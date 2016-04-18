<?php
/**
 * Created by PhpStorm.
 * User: ducan
 * Date: 18.04.2016
 * Time: 0:22
 */

namespace App\Presenters;


class Template01Presenter extends BasePresenter
{
  /** @var FormFactory @inject */
	public $formFactory;

  protected function createComponentForm()
  {
    $form = $this->formFactory->create();
    $form->addText('test_text1', 'Test text 1:')
         ->addText('test_text2', 'Test text 2:')
         ->addText('test_text3', 'Test text 3:')
         ->addSubmit('send', 'Send:');
    return $form;
  }
}
