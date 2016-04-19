<?php


namespace App\Model;


use Nette\Database\Context;
use Nette\Utils\DateTime;

class DbMessageStorage implements IMessageStorage
{

	/** @var  Context */
	protected $db;

	/**
	 * DbMessageStorage constructor.
	 * @param Context $db
	 */
	public function __construct(Context $db)
	{
		$this->db = $db;
	}


	protected function getTable($name = 'messages')
	{
		return $this->db->table($name);
	}

	public function getMessages()
	{
		return $this->getTable()->order('timestamp DESC');
	}

	/**
	 * @param $email
	 * @param $text
	 */
	public function postMessage($email, $text)
	{
		return $this->getTable()->insert([
			'timestamp' => new DateTime,
			'authorEmail' => $email,
		    'text' => $text,
		])->id;
	}

	public function vote($email, $messageId)
	{
		$this->getTable('votes')->insert([
			'message_id' => $messageId,
		    'email' => $email,
		]);
	}

	/**
	 * @param $day
	 * @param $month
	 * @param $year
	 * @return TODO
	 */
	public function getStatistics($day, $month, $year)
	{
		return [
			'TODO'
		];
	}
}
