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

use App\Data\SearchData;
use App\Form\SearchForm;

use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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
    public function index(ArticleRepository $articleRepo, PaginatorInterface $paginator,
                          Request $request): Response
    {
        $search_data = new SearchData();
        $search_form = $this->createForm(SearchForm::class, $search_data);
        //$datas = $articleRepo->findBy([], ['created_at' => 'DESC']);
        //dd($datas);

        //$datas = $articleRepo->listArticles();

        $search_form->handleRequest($request);
        $datas = $articleRepo->findSearch($search_data);
        

        $articles = $paginator->paginate(
            $datas, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3 // Nombre de résultats par page
        );

        return $this->render('article/index.html.twig',
                [
                    'articles' => $articles, 
                    'search_form' => $search_form->createView()
                ]);
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
