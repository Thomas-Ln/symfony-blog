<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\User;
use App\Form\ArticleType;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface as ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article/{id}", name="article", requirements={"id"="\d+"})
     */
    public function index(Article $article, Request $request, ObjectManager $manager, Security $security)
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setCreatedAt(new \DateTime())
                    ->setArticle($article)
                    ->setAuthor($security->getUser());
            $comment = $form->getData();

            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('article', ['id' => $article->getId()]);
        }

        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
            'article' => $article,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/article/new", name="article_create")
     * @Route("/article/{id}/edit", name="article_edit")
     */
    public function form(Article $article = null, Request $request, ObjectManager $manager, Security $security)
    {
        if (!$article) {
            $article = new Article();
        }

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (!$article->getId()) {
                $article->setCreatedAt(new \DateTime())
                        ->setAuthor($security->getUser());
            }
            $article = $form->getData();

            $manager->persist($article);
            $manager->flush();

            $this->addFlash(
                'notice',
                'Your changes were saved!'
            );

            return $this->redirectToRoute('article', ['id' => $article->getId()]);
        }

        return $this->render('article/form.html.twig', [
            'form' => $form->createView(),
            'article' => $article,
            'isNewArticle' => $article->getId() == null
        ]);
    }
}
