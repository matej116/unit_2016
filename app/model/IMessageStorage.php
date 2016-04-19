<?php
namespace App\Model;

interface IMessageStorage
{
	public function getMessages();

	/**
	 * @param $email
	 * @param $text
	 */
	public function postMessage($email, $text);

	public function vote($email, $messageId);

	/**
	 * @param $day
	 * @param $month
	 * @param $year
	 * @return TODO
	 */
	public function getStatistics($day, $month, $year);
	
}
