<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Form\UserFormType;

class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="app_account")
     */
    public function index(): Response
    {
        return $this->render('account/show.html.twig');
    }

    /**
     * @Route("/account/edit", name="app_account_edit")
     */
    public function edit(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        if ( $form->isSubmitted() && $form->isValid() ) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

             $this->addFlash('success', 'Profile utilisateur modifié avec success.');

            return $this->render('account/show.html.twig');
            
        }

        return $this->render('account/edit.html.twig',
                    [
                        'form' => $form->createView()
                    ] 
                );
    }
}
