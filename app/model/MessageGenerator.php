<?php


namespace App\Model;


use Faker\Factory;
use Nette\Database\Context;
use Nette\Database\UniqueConstraintViolationException;

class MessageGenerator
{
	/** @var \Faker\Generator  */
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
				'email' => $this->faker->safeEmail,
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
		    'authorEmail' => $this->faker->safeEmail,
		    'text' => $this->faker->realText()
		]);
	}


}
