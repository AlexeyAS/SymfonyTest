<?php

namespace App\Controller;

use App\Entity\Posting;
use App\Entity\Search;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Form\PostingFormType;
use App\Form\PostingSearchFormType;
use Doctrine\ORM\EntityRepository;


class PostingController extends AbstractController
{

	public function lastMessage()
	{
		//$data = new Posting;
		$data = $this->getDoctrine()->getRepository(Posting::class)->findBy(array(), ['id' => 'DESC'], 3);
		//$data = $posting->addOrderBy('id', 'desc')->take(3)->get();
		return $this->render('page/main.html.twig', ['data' => $data]);
	}

	public function login()
	{
		$data = $this->getDoctrine()->getRepository(Posting::class)->findBy(array(), ['id' => 'DESC'], 3);
		return $this->render('page/home.html.twig', ['data' => $data]);
	}

	public function about()
	{
		return $this->render('page/about.html.twig');
	}

	public function allData()
	{
		$email = $this->get('security.token_storage')->getToken()->getUser()->getUseremail();
		$data = $this->getDoctrine()->getRepository(Posting::class)->findBy(['email' => $email], ['id' => 'DESC']);

		return $this->render('page/posting.html.twig', ['data' => $data]);
	}

	public function showOneMessage($id)
	{
		$data = $this->getDoctrine()->getRepository(Posting::class)->findOneBy(['id' => $id]);
		return $this->render('page/posting-one.html.twig', ['data' => $data]);
	}

	public function updateMessage($id, Request $request): Response
	{
		$data = $this->getDoctrine()->getRepository(Posting::class)->findOneBy(['id' => $id]);

		$form = $this->createForm(PostingFormType::class, $data);
		$form->handleRequest($request);


		if ($form->isSubmitted() && $form->isValid()) {

			//$errors = $validator->validate($data);
			$data->setName($this->get('security.token_storage')->getToken()->getUser()->getUsername());
			$data->setEmail($this->get('security.token_storage')->getToken()->getUser()->getUseremail());
			$req = $request->request->get('posting_form');
			$data->setSubject($req['subject']);
			$data->setMessage($req['message']);
			$data->setCreatedAt(new \DateTime());
			$data->setUpdatedAt(new \DateTime());

			$em = $this->getDoctrine()->getManager();
			$em->persist($data);
			$em->flush();
			$this->addFlash('success', 'Сообщение обновлено');
			return $this->allData();

		}
		return $this->render('page/posting-update.html.twig', [
			'postingForm' => $form->createView(),
			'errorsForm' => $form->getErrors()
		]);
	}

	public function deleteMessage($id)
	{
		$em = $this->getDoctrine()->getManager();
		$data = $em->getRepository(Posting::class)->findOneBy(['id' => $id]);
		$em->remove($data);
		$em->flush();
		$this->addFlash('success', 'Сообшение удалено');
		return $this->allData();
	}

	public function postingNew(Request $request): Response
	{
		$data = new Posting();
		$form = $this->createForm(PostingFormType::class, $data);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

			//$errors = $validator->validate($data);
			$data->setName($this->get('security.token_storage')->getToken()->getUser()->getUsername());
			$data->setEmail($this->get('security.token_storage')->getToken()->getUser()->getUseremail());
			$req = $request->request->get('posting_form');
			$data->setSubject($req['subject']);
			$data->setMessage($req['message']);
			$data->setCreatedAt(new \DateTime());
			$data->setUpdatedAt(new \DateTime());

			$em = $this->getDoctrine()->getManager();
			$em->persist($data);
			$em->flush();
			$this->addFlash('success', 'Пост успешно добавлен');
			return $this->allData();

		}
		return $this->render('page/posting-new.html.twig', [
			'postingForm' => $form->createView(),
			'errorsForm' => $form->getErrors()
		]);
	}

	public function allPosts(Request $request): Response
		//public function allPosts(Request $request, Posting $posting):Response
	{
		$data = new Search();
		$form = $this->createForm(PostingSearchFormType::class, $data);
		$form->handleRequest($request);
		$req = $request->request->get('posting_search_form');

		$em = $this->getDoctrine()->getManager();


//https://symfony.com/doc/3.4/doctrine/repository.html

		if($req){
			$filter_name = $req['name'];
			$filter_text = $req['text'];
			if ($filter_name and $filter_text)
				$postings = $em->createQuery('SELECT p FROM App:Posting p WHERE p.name LIKE :name AND p.message LIKE :text ORDER BY p.id DESC')->setParameter('name', '%'.$filter_name.'%')->setParameter('text', '%'.$filter_text.'%')->getResult();
			elseif ($filter_name)
				$postings = $em->createQuery('SELECT p FROM App:Posting p WHERE p.name LIKE :name ORDER BY p.id DESC')->setParameter('name', '%'.$filter_name.'%')->getResult();
			elseif ($filter_text)
				$postings = $em->createQuery('SELECT p FROM App:Posting p WHERE p.message LIKE :text ORDER BY p.id DESC')->setParameter('text', '%'.$filter_text.'%')->getResult();
			else
			$postings = $em->getRepository(Posting::class)->findBy([], ['id' => 'DESC']);
		} else {
			$postings = $em->getRepository(Posting::class)->findBy([], ['id' => 'DESC']);
		}


		//$em = $this->getDoctrine()->getManager()->createQueryBuilder();
		//$qb = $em->createQueryBuilder('p')->andWhere('p.name IN (:name)')->setParameter('name', $name)->orderBy('p.id', 'DESC');

		//$postings = $em->getRepository(Posting::class)->findBy(['name' => $name], ['id' => 'DESC']);
		//$postings =  $em->createQueryBuilder('a')
		//	->andWhere('a.name LIKE (:name)')->setParameter('name', $name)
		//	->getQuery()->getResult();
		//$qb=$em->select(array('p'))
		//	->from('Posting:Posting', 'p')
		//	->where('p.name', $name)
		//	->orderBy('p.id', 'DESC');
		//$postings = $qb->getQuery()->getResult();

		//$q = $em->createQueryBuilder('p')->select()
		//	->where('p.name = :postingName')
		//	->setParameter('postingName', $name)
		//	->getQuery();
		//$postings = $q->getResult();

		return $this->render('page/postings.html.twig', [
			'postings' => $postings,
			'request' => $req,
			'searchForm' => $form->createView(),
			'errorsForm' => $form->getErrors()
		]);
	}

	public function listAction(Request $request)
	{
		$em = $this->get('doctrine.orm.entity_manager');
		$dql = "SELECT a FROM AcmeMainBundle:Article a";
		$query = $em->createQuery($dql);

		$paginator = $this->get('knp_paginator');
		$pagination = $paginator->paginate(
			$query, /* query NOT result */
			$request->query->getInt('page', 1)/*page number*/,
			10/*limit per page*/
		);

		// parameters to template
		return $this->render('AcmeMainBundle:Article:list.html.twig',
			['pagination' => $pagination]);
	}
}