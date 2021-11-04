<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * 
 * @Route("/test/access/admin")
 */ 
class TestAccessAdminController extends AbstractController
{
    /**
     * @Route("/", name="app_test_access_admin")
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('test_access_admin/index.html.twig', [
            'controller_name' => 'TestAccessAdminController',
        ]);
    }
}
