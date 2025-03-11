<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Form\UserType;
use App\Service\FileService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user')]
final class UserController extends AbstractController
{
    private $em;
    private $fileService;

    /**
     * @param $em
     */
    public function __construct(EntityManagerInterface $em, FileService $fileService) {
        $this->em = $em;
        $this->fileService = $fileService;
    }

    #[Route('/register', name: 'user_register')]
    public function userRegister(Request $request, UserPasswordHasherInterface $passwordHasher): Response {
        $user = new User();
        $registerForm = $this->createForm(RegisterType::class, $user);
        $registerForm->handleRequest($request);
        if ($registerForm->isSubmitted() && $registerForm->isValid()) {
            $plainPassword = $registerForm->get('password')->getData();
            $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);
            $this->em->persist($user);
            $this->em->flush();
            return $this->redirectToRoute('main_page');
        }
        return $this->render('user/register.html.twig', [
            'register_form' => $registerForm->createView()
        ]);
    }

    #[Route('/profile', name: 'user_profile')]
    public function userProfile (Request $request) {
        $user = $this->getUser();
        $userForm = $this->createForm(UserType::class, $user);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $file = $userForm->get('photo')->getData();
            $fileName = $this->fileService->uploadFile($file);
            $user->setPhoto($fileName);
            $this->em->flush();
            return  $this->redirectToRoute('user_profile');
        }
        return $this->render('user/profile.html.twig', ['user_form' => $userForm->createView()]);
    }
}
