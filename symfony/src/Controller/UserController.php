<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use App\Entity\Posting;
use App\Entity\Search;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Form\UserSearchFormType;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class UserController extends AbstractController
{
	/**
	 * @Route("/users/?page={page}", defaults={"page" = 1}, name="users")
	 * @Route("/users")
	 * @Template()
	 */
	public function allUsers(Request $request, PaginatorInterface $paginator) : Response
	{
		$data = new Search();
		$form = $this->createForm(UserSearchFormType::class, $data);

		$form->handleRequest($request);
		$req = $request->get('user_search_form');
		$em = $this->getDoctrine()->getManager();
		$dql = 'SELECT DISTINCT u.name, u.email FROM App\Entity\User u ';

		$filter_name = $req['name'] ?? '';
		$filter_email = $req['email'] ?? '';

		if (!empty($filter_name)) $dql .= 'WHERE u.name LIKE :name ';
		if (!empty($filter_name) and !empty($filter_email)) $dql .= 'AND u.email = :email ';
			elseif(!empty($filter_email)) $dql .= 'WHERE u.email = :email ';

		$users = $em->createQuery($dql.'ORDER BY u.name DESC');
		if (strpos($dql,':name'))
			$users = $users->setParameter('name', '%'.$filter_name.'%');
		if (strpos($dql,':email'))
			$users = $users->setParameter('email', $filter_email);
		$users = $users->getResult();

		foreach ($users as $user) {
			$name = $user['name'];
			$posting = $em->createQuery('SELECT p.id FROM App\Entity\Posting p WHERE p.name = :name ORDER BY p.id DESC')
				->setParameter('name', $name)
				->getResult();
			$count = count($posting);
			if ($count > 0)
			{
				$postings[$name]['count'] = $count;
				$postings[$name]['createdAt'] = $em->getRepository(Posting::class)->find($posting[0]["id"])->getCreatedAt();
			} else {
				$postings[$name]['count'] = '-';
				$postings[$name]['createdAt'] = '-';
			}
		}

		$pagination = $paginator->paginate(
			$users, /* query NOT result */
			$request->query->getInt('page', 1),/*page number*/
			3,/*limit per page*/
		);

		return $this->render('page/users.html.twig', [
			'postings'   => $postings,
			'pagination' => $pagination,
			'searchForm' => $form->createView(),
			'errorsForm' => $form->getErrors(),
		]);
	}
}