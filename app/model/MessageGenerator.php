<?php


namespace App\Model;


use Faker\Factory;
use Nette\Database\Context;
use Nette\Database\UniqueConstraintViolationException;

class MessageGenerator
{
	/** @var \Faker\Generator */
	protected $faker;
	/**
	 * @var Context
	 */
	private $db;


	/**
	 * MessageGenerator constructor.
	 */
	public function __construct(Context $db)
	{
		$this->faker = Factory::create('cs_CZ');
		$this->db = $db;
	}

	public function something($count = 1)
	{
		for ($i = 0; $i < $count; $i++) {
			$this->one();
		}
	}

	public function one()
	{
		if ($this->faker->boolean) {
			$this->vote();
		} else {
			$this->message();
		}
	}

	protected function email()
	{
		static $mostEmails = [
			"krecek.peter@example.net",
			"adam52@example.org",
			"dhorvat@example.org",
			"spicha@example.com",
			"lubos87@example.org",
			"neumanova.rudolf@example.net",
			"rozsypalova.kamila@example.org",
			"maria10@example.com",
			"vitova.vladislav@example.org",
			"vitova.vladislava@example.org",
		];
		if ($this->faker->boolean(80)) {
			return $this->faker->randomElement($mostEmails);
		} else {
			return $this->faker->safeEmail;
		}
	}

	protected function vote()
	{
		$messageIds = $this->db->table('messages')->where('timestamp > CURDATE()')->fetchPairs('id', 'id');

		if (count($messageIds) === 0) {
			return FALSE;
		}

		$id = $this->faker->randomElement($messageIds);

		try {
			$this->db->table('votes')->insert([
				'message_id' => $id,
				'email' => $this->email(),
				'timestamp' => $this->faker->dateTimeBetween('-20 hours'),
			]);
		} catch (UniqueConstraintViolationException $ex) {
			return FALSE;
		}

		return TRUE;
	}

	private function message()
	{
		$this->db->table('messages')->insert([
			'timestamp' => $this->faker->dateTimeBetween('-3 second'),
			'authorEmail' => $this->email(),
			'text' => $this->faker->realText(),
		]);
	}


}
