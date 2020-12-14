<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{


	/**
	 * @Route("/add_category",name="add_category")
	 */
	public function addCategory()
	{
		return $this->render('category/add_category.html.twig', [
		]);
	}

	/**
	 * @Route("/show_categories", name="show_categories")
	 */
	public function showCategories()
	{
		$categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
		return $this->render('category/show_categories.html.twig', [
			'categories' => $categories,
		]);
	}
}
