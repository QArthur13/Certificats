<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DefaultController extends AbstractController
{
    /**
     * @Route ("/creation", name="user_create")
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function userCreation(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $userForm = $this->createForm(UserType::class, $user);
        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()){

            $entityManager = $this->getDoctrine()->getManager();

            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Votre compte à bien été créer! :)');

            return $this->redirectToRoute('default');
        }

        return$this->render('create.html.twig', [

            'userForm' =>$userForm->createView()
        ]);
    }

    /**
     * @Route("/", name="default")
     */
    public function index(): Response
    {
        return $this->render('home.html.twig', []);
    }
}
