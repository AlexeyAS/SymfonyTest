<?php

namespace App\Controller;

use App\Entity\Video;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class VideoController extends AbstractController
{
    /**
     * @Route("/video", name="video")
     */
    public function showVideos()
    {
    	$videos = $this->getDoctrine()->getRepository(Video::class)->findAllWithCategories();
    	return $this->render('video/show_video.html.twig', [
			'videos' => $videos
        ]);
    }

	/**
	 * @Route("show_video/{youtube_id}", name="show_video")
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
    public function showOneVideo($youtube_id)
	{
		$video = $this->getDoctrine()->getRepository(Video::class)->findBy(['youtube_id' => $youtube_id]);
		return $this->render('video/show_one_video.html.twig', ['video' => $video[0]]);

	}

	/**
	 * @Route("/addvideo", name="addvideo")
	 */
	public function addVideo()
	{
		return $this->render('video/addvideo.html.twig', [

		]);
	}

	/**
	 * @Route("/show_video_by_cat/{category_id}", name="show_video_by_cat", requirements={"category_id"="\d"})
	 */

	public function showByCategory(int $category_id)
	{
		$videos = $this->getDoctrine()->getRepository(Video::class)->findByCategory($category_id);
		return $this->render('video/show_video.html.twig', ['videos' => $videos]);
	}
}
