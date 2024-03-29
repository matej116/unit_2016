<?php

namespace App\Presenters;

use GuzzleHttp;
use Maknz\Slack\Message;
use Nette;
use App\Model;
use Psr\Http\Message\MessageInterface;


class HomepagePresenter extends BasePresenter
{
    /** @var Model\SlackApi @inject */
    public $slackApi;

    /** @var Model\DbMessageStorage @inject */
    public $messagesStorage;

    private $CLIENT_ID = '34986258439.35402087824';
    private $CLIENT_SECRET = '2f05735ef69278dc7eeff195591f85ce';


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

        $token = $responseJSON['access_token'];

        $this->slackApi->saveToken($token);

        $this->redirect('default');
    }

    public function actionHistory()
    {
        $token = 'xoxp-34986258439-35514919412-35877375588-79da75bb83';

        $requestArray = array('token' => $token,
            'channel' => 'C10VBLY6N');

        $responseJSON = $this->sendApiRequest($requestArray, 'channels.history');

        $messages = $responseJSON['messages'];


        $lastTimestamp = $this->slackApi->cache->load('last-slack-ts', 0);

        foreach($messages as $message){

            if ($message['ts'] > $lastTimestamp) {

                if (isset($message['username'])) {
                    $user = $message['username'];

                    $this->messagesStorage->postMessage($user, $message['text'], $message['ts']);
                }
                $lastTimestamp = $message['ts'];
            }

           // die();
        }
        
        $this->slackApi->cache->save('last-slack-ts', $lastTimestamp);

        $this->redirect('default');
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
        return Nette\Utils\Json::decode($response->getBody(), Nette\Utils\Json::FORCE_ARRAY);
    }
}
