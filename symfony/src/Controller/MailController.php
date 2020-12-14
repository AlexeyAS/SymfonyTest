<?php


namespace App\Controller;

use App\Entity\Mail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class MailController extends AbstractController
{
	public function send()
	{
		Mail::send(new Mail());
		return redirect()->route('main')->with('success', 'Спам отправлен');
	}

	public function email()
	{
		return view('email');
	}
}