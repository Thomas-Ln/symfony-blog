<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(ArticleRepository $articleRepo)
    {
        return $this->render('blog/index.html.twig', [
            'articles' => $articleRepo->findBy(array(), array('createdAt' => 'DESC'))
        ]);
    }
}
