<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * 
 * @Route("/admin")
 * 
 */ 

class HomePageBoController extends AbstractController
{
    /**
     * @Route("/", name="home_page_admin")
     */
    public function index(): Response
    {
        return $this->render('home_page_bo/index.html.twig');
    }
}
