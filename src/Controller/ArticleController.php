<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use App\Entity\Article;
use App\Form\ArticleTypeType;
use App\Repository\ArticleRepository;

use Doctrine\ORM\EntityManagerInterface;
/**
 * 
 * @Route("/article")
 * 
 * @Security("is_granted('ROLE_EDITOR')")
 * 
 **/ 
class ArticleController extends AbstractController
{
    public $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route("/", name="app_article")
     */
    public function index(): Response
    {
        return $this->render('article/index.html.twig');
    }


    /**
     * 
     * @Route("/add", name="app_add_article", methods={"GET|POST"})
     * 
     **/ 
    public function addArticle(Request $request)
    {
        $article = new Article;
        $form = $this->createForm(ArticleTypeType::class, $article);

        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid() ) {
            //dd($form['designation']->getData());

            $article->setCreatedAt(new \DatetimeImmutable());

            $this->em->persist($article);
            $this->em->flush();

            $this->addFlash('success', 'L\'article a été enrogistré avec succée .');

            return $this->redirectToRoute('app_article');

        }
        return $this->render('article/add_article.html.twig', 
                [
                    'form' => $form->createView()
                ]);
    }

    /**
     * 
     * @Route("/{id<[0-9+]>}/edit", name="app_edit_article", methods={"GET|POST"})
     * 
     **/ 
    public function editArticle(Request $request, ArticleRepository $articleRepo, Article $article)
    {
        //$article = $articleRepo->find(['id' => $id]);
        $form = $this->createForm(ArticleTypeType::class, $article);

        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid() ) {
            //dd($form['designation']->getData());

            $article->setUpdatedAt(new \DatetimeImmutable());

            $this->em->flush();

            $this->addFlash('success', 'L\'article a été modifie
             avec succée .');

            return $this->redirectToRoute('app_article');

        }
        return $this->render('article/edit_article.html.twig', 
                [
                    'form' => $form->createView()
                ]);
    }
}
