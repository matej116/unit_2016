<?php

namespace App\Presenters;

use Nette;
use App\Model;


class HomepagePresenter extends BasePresenter
{

    public function renderDefault()
    {
        $this->template->anyVariable = 'any value';
    }

    public function renderSlackAuth($code, $state){
        var_dump($code);
        exit(0);
    }

}
