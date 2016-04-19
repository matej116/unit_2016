<?php


namespace App\Model;
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

	}
	
	public function vote($email, $messageId)
	{

	}

	/**
	 * @param $day
	 * @param $month
	 * @param $year
	 * @return TODO
	 */
	public function getStatistics($day, $month, $year)
	{

	}

}
