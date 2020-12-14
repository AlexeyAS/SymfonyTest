<?php


namespace App\Entity;

use App\Repository\MailRepository;
use Doctrine\ORM\Mapping as ORM;


class Mail extends Mailable
{
	use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->markdown('email');
	}
}
