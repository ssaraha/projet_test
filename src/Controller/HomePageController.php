<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;

use Knp\Component\Pager\PaginatorInterface;

use App\Repository\ArticleTypeRepository;
use App\Repository\ArticleRepository;
use App\Repository\PromoRepository;

use App\Service\Helper;

use App\Entity\Article;
use App\Entity\Sale;
use App\Entity\SaleDetail;
//use App\Repository\ArticleTypeRepository;

class HomePageController extends AbstractController
{
    /**
     * @Route("/", name="home_page")
     */
    public function index(ArticleTypeRepository $typeArtRepo): Response
    {
        $type_articles = $typeArtRepo->findAll();
        
        return $this->render('home_page/index.html.twig',
                    [
                        'type_articles' => $type_articles
                    ] 
                );
    }

    /**
     * 
     * @Route("/article/{type_article}/{id_type_article<[0-9]>}", name="app_article_liste")
     * 
     **/
    public function getArticleViaType(ArticleRepository $articleRepo, $id_type_article,
                                        ArticleTypeRepository $typeArtRepo,
                                        PaginatorInterface $paginator, PromoRepository $promoRepo,
                                        Request $request
                                    )
    {

        $promos = $promoRepo->findAll();
        
        $type_articles = $typeArtRepo->findAll();
        $articles_data = $articleRepo->findBy(['typeArticle' => $id_type_article]);
        $articles = $paginator->paginate(
            $articles_data, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3 // Nombre de résultats par page
        );
        return $this->render('home_page/article.html.twig', 
                    [
                        'promos' => $promos,
                        'articles' => $articles, 
                        'type_articles' => $type_articles
                    ]
                );
    }

    /**
     * 
     * @Route("/article/{id<[0-9]+>}/detail/", name="app_article_to_buy")
     * 
     **/ 
    public function detailToBuy(ArticleRepository $artRepo,
                                ArticleTypeRepository $typeArtRepo,
                                PromoRepository $promoRepo, 
                                $id)
    {
        $type_articles = $typeArtRepo->findAll();
        $promos = $promoRepo->findAll();
        $article = $artRepo->find($id);

        return $this->render('article/article_detail_to_buy.html.twig', 
                [
                    'article' => $article,
                    'type_articles' => $type_articles,
                    'promos' => $promos  
                ]
              );
    }

    /**
     * 
     * @Route("/panier", name="app_panier")
     * 
     * @Security("is_granted('ROLE_USER')")
     */ 
    public  function panier(SessionInterface $session,
                            ArticleRepository $artRepo, 
                            ArticleTypeRepository $typeArtRepo,
                            PromoRepository $promoRepo
                        )
    {
        $panierWithData = [];
        $articles = [];
        $promos = $promoRepo->findAll();
        $type_articles = $typeArtRepo->findAll();
        $panier = $session->get('panier', []);
        $total = 0;

        foreach ($panier as $key => $value) {
            $article = $artRepo->find($key);
            $articles[] = $article;
            $panierWithData[] = [   
                                    'quantity' => $value,
                                    'article' => $article
                                ];
        }


        return $this->render('article/panier.html.twig', 
                [
                    'panierData' => $panierWithData,
                    'type_articles' => $type_articles,
                    'promos' => $promos,
                    'array_articles' => $articles
                ]);
    }

    /**
     * 
     * @Route("/add_card/{id<[0-9]+>}", name="app_add_card", methods={"POST"})
     * @Security("is_granted('ROLE_USER')")
     * 
     */ 
    public function addCard(Request $request, $id, 
                            SessionInterface $session,
                            ArticleRepository $artRepo,
                            PromoRepository $promoRepo,
                            ArticleTypeRepository $typeArtRepo)
    {
        $panierWithData = [];
        $promos = $promoRepo->findAll();
        $type_articles = $typeArtRepo->findAll();
        $panier = $session->get('panier', []);

        if ( !empty($panier[$id]) )
            $panier[$id] += (int) $request->request->get('quantity');
        else
            $panier[$id] = (int) $request->request->get('quantity');

        $session->set('panier', $panier);

         foreach ($panier as $key => $value) {
            $article = $artRepo->find($key);
            $articles[] = $article;
            $panierWithData[] = [   
                                    'quantity' => $value,
                                    'article' => $article
                                ];
        }


        return $this->redirectToRoute('app_panier');
       /* return $this->render('article/panier.html.twig', 
                            [
                                'type_articles' => $type_articles,
                                'panierData' => $panierWithData, 
                                'promos' => $promos,
                            ]);*/
    }

    /**
     * 
     * 
     * @Route("/panier/remove/{id<[0-9]+>}", name="app_remove_article_card")
     * 
     * 
     **/ 
    public function removeArticleInCard(Article $article, SessionInterface $session)
    {
        $panier = $session->get('panier', []);

        if ( !empty($panier[$article->getId()]) ) {
            //dd($panier[$article->getId()]);
            unset($panier[$article->getId()]);
        }
        $session->set('panier', $panier);

        return $this->redirectToRoute('app_panier');
    }

    /**
     * 
     * @Route("/panier/change_quantity", name="app_panier_change_quantity")
     * 
     **/ 
    public function changeQuantityInCard(Request $request, 
                                        SessionInterface $session,
                                        Helper $helper,
                                        ArticleRepository $artRepo,
                                        PromoRepository $promoRepo,
                                        EntityManagerInterface $em
                                        )
    {

        $id = $request->request->get('id');

        $price = $helper->getPromotionPrice($artRepo->find($id),
                                            $promoRepo->findAll()
                                            );

        $quantity = $request->request->get('quantity');
        $panier = $session->get('panier', []);
        if ( !empty($panier[$id]) ) {
            $panier[$id] = (int)$quantity;
            $article = $artRepo->find($id);
            $article->setQuantityAvailable(
                      $article->getQuantityAvailable() - (int)$quantity);             
            $session->set('panier', $panier);

            $em->flush(); 
        }

        
        return new JsonResponse(
            [
                'id' => $id,
                'quantity' => $quantity,
                'priceArticle' => $price * $quantity
            ]);
    }

    /**
     * 
     * @Route("/panier/validate", name="app_panier_validate", methods={"POST"})
     * 
     */     
    public function validate(Request $request, 
                            ArticleRepository $artRepo, 
                            EntityManagerInterface $em,
                            SessionInterface $session)
    {
        $sale = new Sale;
        $panier = $session->get('panier', []);

        $sale->setDateSale(new \DateTimeImmutable);
        $sale->settotal($request->request->get('txt_total'));
        $sale->setUser($this->getUser());
        $sale->setCreatedAt(new \DateTimeImmutable);

        foreach( $request->request as $key => $val)
        {
            if( substr( $key, 0, 14 ) == 'txt_article_id' )
            {
                $array_key = explode("_", $key);
                $id = end($array_key); 
                $article = $artRepo->find($id);
                $sale_detail = new SaleDetail;
                $sale_detail->setArticle($artRepo->find($id));
                $sale_detail->setQuantity($request->request->get('txt_article_quantity_'.$id));
                $sale_detail->setPrice($request->request->get('txt_price_'.$id));
                $sale_detail->setSlae($sale);
                $sale_detail->setCreatedAt(new \DateTimeImmutable);

                $article->setQuantityAvailable(
                    $article->getQuantityAvailable() - (int) $request->request->get('txt_article_quantity_'.$id));
                
                unset($panier[$id]);
                $em->persist($sale_detail);
            }
        }
        
        $em->persist($sale);
        $em->flush();

        return new Response('OKKK');
    }
}
