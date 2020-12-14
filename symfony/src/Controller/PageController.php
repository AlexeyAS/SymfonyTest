<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Page;

class PageController extends AbstractController
{

	public function index()
	{
		/*
		$entityManager = $this->getDoctrine()->getManager();
		$page = new Page();
		$page->setKeywords('Избранные видео')
			->setDescription('Избранные видео')
			->setTitle('Избранные видео')
			->setContent('говносайт для Избранных видео');
		$entityManager->persist($page);
		$entityManager->flush();
*/

		$homePage = $this->getDoctrine()->getRepository(Page::class)->find(1);
		return $this->render('page/main.html.twig', ['homePage' => $homePage, 'test_1' => 'Вывод переменной test_1']);

	}

}
