<?php

namespace App\Forms;

use Instante\Bootstrap3Renderer\BootstrapRenderer;
use Nette;
use Nette\Application\UI\Form;


class FormFactory extends Nette\Object
{

	/**
	 * @return Form
	 */
	public function create()
	{
		$form = new Form;
		$form->setRenderer(new BootstrapRenderer);
		return $form;
	}

}
