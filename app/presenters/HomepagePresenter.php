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
        $clientId = '34986258439.35667661124';

        $client = new \GuzzleHttp\Client();
        $response =  $client->post('https://slack.com/api/oauth.access', [
            'headers' => [
                'content-type' => 'application/json',
            ],
            'body' => json_encode([
                'client_id' => $clientId,
                'client_secret' => '0557658ce0dea7b7683f4a5921de53b0',
                'code' => $code,
            ]),
        ]);

        echo $response->getBody()->getContents();


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
