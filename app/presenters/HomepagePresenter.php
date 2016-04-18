<?php

namespace App\Presenters;

use Maknz\Slack\Message;
use Nette;
use App\Model;


class HomepagePresenter extends BasePresenter
{

    public function renderDefault()
    {
        $this->template->anyVariable = 'any value';
    }

    public function renderSlackAuth($code, $state)
    {
        var_dump($code);
        exit(0);
    }

    public function renderTest()
    {
        $client = new \Maknz\Slack\Client('https://hooks.slack.com/services/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');

        $msg = new Message($client);
        $msg->setText('test');

        $msg->send();

        $this->terminate();
    }

}
