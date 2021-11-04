<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class TestOtherAccessController extends AbstractController
{
    /**
     * @Route("/test/other/access", name="test_other_access")
     */
    public function index(): Response
    {
        if ( !$this->getUser() ) {
            throw $this->createAccessDeniedException('Veuillez connecté avant de visiter cette page.');
        }

        if ( !$this->getUser()->isVerified() ) {
            throw $this->createAccessDeniedException('Veuillez verifier votre compte.');
        }

        return $this->render('test_other_access/index.html.twig');
    }

    /**
     * @Route("/test/verify/access", name="test_verify_access")
     * 
     * @Security("is_granted('ROLE_USER') && user.isVerified()", message="Erreur ")
     */
    public function checkAuthorization(): Response
    {
        //Une autre moyen de checker l'autorisation d'un utilsateur

        return $this->render('test_other_access/index.html.twig');
    }
}
