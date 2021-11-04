<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/test/autre/access/admin")
 * 
 * @IsGranted("ROLE_ADMIN")
 * 
 */ 
class TestAutreAccessAdminController extends AbstractController
{
    /**
     * @Route("/", name="app_test_autre_access_admin")
     */
    public function index(): Response
    {
        return $this->render('test_autre_access_admin/index.html.twig', [
            'controller_name' => 'TestAutreAccessAdminController',
        ]);
    }
}
