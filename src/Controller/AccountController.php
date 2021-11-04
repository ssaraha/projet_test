<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Form\UserFormType;
use App\Form\ChangePasswordFormType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

    /**
     * @Route("/account")
     * 
     */
class AccountController extends AbstractController
{
    /**
     * @Route("/", name="app_account", methods={"GET"})
     */
    public function index(): Response
    {
        /*if( !$this->getUser() ) //Remplacer par la configuration de l'url dans le fichier security.yaml
        {
            $this->addFlash('error', 'Vous avez besoin de se connectez'); 
            Ou utilisé une exception au ieu de flashbag
            throw $this->reateAccessDeniedException("Your message")

            return $this->redirectToRoute('app_login');
        }*/

        return $this->render('account/show.html.twig');
    }

    /**
     * @Route("/edit", name="app_account_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request): Response
    {
        /*if( !$this->getUser() )
        {
            $this->addFlash('error', 'Vous avez besoin de se connectez');

            return $this->redirectToRoute('app_login');

        }*/

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

    /**
     * @Route("/change-password", name="app_account_change_password", methods={"GET", "POST"})
     */
    public function changePassword(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        /*if( !$this->getUser() )
        {
            $this->addFlash('error', 'Vous avez besoin de se connectez');

            return $this->redirectToRoute('app_login');
        }*/

        $form = $this->createForm(ChangePasswordFormType::class, null, [
                    'current_paasword_is_required' => true
                ]);


        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid() ) {
            $user = $this->getUser();

             $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $em->flush();

            $this->addFlash('success', 'Profile utilisateur modifié avec success.');

            return $this->render('account/show.html.twig');

        }

        return $this->render('account/change_password.html.twig', 
                [
                    'form' => $form->createView()
                ]);
    }
}
