<?php


namespace App\Model;


use Nette\Database\Context;
use Nette\Database\Table\Selection;
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

	public function getMessages($limit = 50)
	{
		$selection = $this->getTable()->order('timestamp DESC');
		if ($limit) {
			$selection->limit($limit);
		}
		return $selection;
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
			'timestamp' => new DateTime,
		]);
	}

	protected static function statsMessages(Selection $selection)
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
		$dayBegin = (new DateTime())->setDate($year, $month, $day)->setTime(0, 0, 0);
		$dayEnd = $dayBegin->modifyClone('+24 hours');

		/** @var Selection $dayMessages */
		$dayMessages = $this->getTable()->where('timestamp BETWEEN (?, ?)', $dayBegin, $dayEnd);

		return [
			'dayStats' => [
				'topTenMessages' => $dayMessages->order('COUNT(:votes) DESC')->limit(10),
				'topTenAuthors' => $dayMessages->select('authorEmail, COUNT(:votes) votes')->group('authorEmail')->order('votes DESC')->limit(10),
			],
			'weekStats' => [
				'topTenMessages' => $dayMessages->order('COUNT(:votes) DESC')->limit(10),
				'topTenAuthors' => $dayMessages->select('authorEmail, COUNT(:votes) votes')->group('authorEmail')->order('votes DESC')->limit(10),
			],
			'',
		];
	}

	public function countDay(DateTime $date = NULL)
	{
		$date = $date ?: new DateTime;
		$dayBegin = $date->setTime(0, 0, 0);
		$dayEnd = $dayBegin->modifyClone('+24 hours');

		return [
			'votes' => $this->getTable('votes')->where('timestamp BETWEEN ? AND ?', $dayBegin, $dayEnd)->count('*'),
			'messages' => $this->getTable('messages')->where('timestamp BETWEEN ? AND ?', $dayBegin, $dayEnd)->count('*'),
		];
	}

	public function topTenPeoplePerDay(DateTime $date = NULL)
	{
		$date = $date ?: new DateTime;
		$dayBegin = $date->setTime(0, 0, 0);
		$dayEnd = $dayBegin->modifyClone('+24 hours');

		return $this->getTable('messages')
			->where('messages.timestamp BETWEEN ? AND ?', $dayBegin, $dayEnd)
			->group('messages.authorEmail')
			->select('authorEmail, COUNT(*) messages, COUNT(:votes.id) votes')
			->order('messages DESC, votes DESC')->limit(10);
	}

	public function topTenMessagesPerDay(DateTime $date = NULL)
	{
		$date = $date ?: new DateTime;
		$dayBegin = $date->setTime(0, 0, 0);
		$dayEnd = $dayBegin->modifyClone('+24 hours');

		return $this->getTable('messages')
			->where('messages.timestamp BETWEEN ? AND ?', $dayBegin, $dayEnd)
			->group('messages.id')
			->select('messages.*, COUNT(:votes.id) AS votes')
			->order('votes DESC')->limit(10);
	}


}
