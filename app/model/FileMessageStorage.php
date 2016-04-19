<?php


namespace App\Model;


/**
 * TODO exclusive lock
 * Class FileMessageStorage
 * @package App\Model
 */
class FileMessageStorage implements IMessageStorage
{

	const FILE = __DIR__  . '/../data/messages.json';



	public function getMessages()
	{
		return json_decode(file_get_contents(self::FILE));
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
