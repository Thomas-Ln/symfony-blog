<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article/{id}", name="article", requirements={"id"="\d+"})
     */
    public function index(Article $article)
    {
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
            'article' => $article
        ]);
    }
}
