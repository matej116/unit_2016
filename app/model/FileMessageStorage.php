<?php


namespace App\Model;
use Composer\Package\Locker;
use Nette\InvalidStateException;
use Nette\IOException;
use Nette\Utils\DateTime;
use Nette\Utils\Json;


/**
 * TODO exclusive lock
 * Class FileMessageStorage
 * @package App\Model
 */
class FileMessageStorage implements IMessageStorage
{


	private $file;

	/**
	 * FileMessageStorage constructor.
	 * @param string $file
	 */
	public function __construct($file = NULL)
	{
		$this->file = $file ?: __DIR__  . '/../data/messages.json';
	}


	/** http://stackoverflow.com/questions/21671179/how-to-generate-a-new-guid */
	private static function guid()
	{
		if (function_exists('com_create_guid') === true)
		{
			return trim(com_create_guid(), '{}');
		}

		return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
	}


	public function getMessages()
	{
		return Json::decode(file_get_contents($this->file), Json::FORCE_ARRAY);
	}

	/**
	 * @param $email
	 * @param $text
	 */
	public function postMessage($email, $text)
	{
		$data =  Json::decode(file_get_contents($this->file));
		$data[] = [
			'guid' => self::guid(),
			'authorEmail' => $email,
		    'text' => $text,
		    'timestamp' => DateTime::from('now')->format('c'),
		    'votes' => [],
		];
		file_put_contents($this->file, Json::encode($data, Json::PRETTY));

	}
	
	public function vote($email, $messageId)
	{
		$data = Json::decode(file_get_contents($this->file));

		$found = array_filter($data, function($message) use ($messageId) {
			return $message['guid'] === $messageId;
		});

		if ($found) {
			$found['votes'][] = $email;
			file_put_contents($this->file, Json::encode($data, Json::PRETTY));
			return TRUE;
		}

		return FALSE;
	}

	/**
	 * @param $day
	 * @param $month
	 * @param $year
	 * @return
	 *
	 * {
  "dayStats": {
    "topTenMessages": [
      {
        "guid": "MOND-0005",
        "timestamp": "2016-04-12T13:47:23.273Z",
        "authorEmail": "john@doe.com",
        "text": "Monday message #5 with 4 votes",
        "votes": [
          "johny@walker.com",
          "jim@beam.com",
          "jack@daniels.com",
          "ron@zacapa.com"
        ]
      },
      {
        "guid": "MOND-0008",
        "timestamp": "2016-04-12T14:47:23.273Z",
        "authorEmail": "jane@doe.com",
        "text": "Monday message #8 with 2 votes",
        "votes": [
          "johny@walker.com",
          "jim@beam.com"
        ]
      },
      ...
    ],
    "topTenAuthors": [
      {
        "authorEmail": "jane@doe.com",
        "votes": 9
      },
      {
        "authorEmail": "john@doe.com",
        "votes": 7
      },
      {
        "authorEmail": "jessie@doe.com",
        "votes": 1
      },
      ...
    ]
  },
  "weekStats": {
    ...
  }
}
Status
	 */
	public function getStatistics($day, $month, $year)
	{
		$date = new DateTime();
		$date->setDate($year, $month, $day);

		$data = Json::decode(file_get_contents($this->file));

	}

}
