<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\CreateAccountType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/connexion', name: 'security.login', methods:['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {

        return $this->render('pages/security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError()
        ]);
    }
    #[Route('/logout', 'security.logout')]
    public function logout()
    {

    }
    #[Route('/createAccount', 'security.createAccount', methods:['GET', 'POST'])]
    public function CreationAccount(Request $request, EntityManagerInterface $manager) : Response
    {
        $user = new User();
        $user->setRoles(['ROLE_USER']);

        $form = $this->createForm(CreateAccountType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $user = $form->getData();
            $manager->persist($user);
            $manager->flush();
            
            $this->addFlash(
                'success',
                'le compte à bien était créer !',
            );

            return $this->redirectToRoute('home.index');
        }

        return $this->render('pages/security/createAccount.html.twig', [
            'form' => $form->createView(),
        ]);
    } 
}
