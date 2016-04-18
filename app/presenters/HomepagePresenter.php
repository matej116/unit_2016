<?php

namespace App\Presenters;

use GuzzleHttp;
use Maknz\Slack\Message;
use Nette;
use App\Model;
use Psr\Http\Message\MessageInterface;


class HomepagePresenter extends BasePresenter
{

    private $CLIENT_ID = '34986258439.35402087824';
    private $CLIENT_SECRET = '2f05735ef69278dc7eeff195591f85ce';

    public function renderDefault()
    {
        $this->template->anyVariable = 'any value';
    }

    /**
     * @param $contentArray Array (like JSON) of parameters to send
     * @param $apiMethod string SlackApi method (oauth.access, channels.list)
     *
     * @return mixed JSON
     */
    public function sendApiRequest($contentArray, $apiMethod)
    {
        $client = new GuzzleHttp\Client(['base_uri' => 'https://slack.com/api/']);

        $response = $client->request('GET', $apiMethod, ['query' => $contentArray]);

        return $this->getJsonFromResponse($response);
    }

    public function renderSlackAuth($code, $state)
    {
        $requestArray = array('client_id' => $this->CLIENT_ID,
            'client_secret' => $this->CLIENT_SECRET,
            'code' => $code);

        $responseJSON = $this->sendApiRequest($requestArray, 'oauth.access');

        var_dump($responseJSON);
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

    private function getJsonFromResponse(MessageInterface $response)
    {
        return Nette\Utils\Json::decode($response->getBody());
    }
}