<?php

namespace App\Controller;

use App\Entity\Education;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user')]
final class EndPointController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    #[Route('/save-education', name: 'save_education')]
    public function SaveEducation(Request $request): Response {
        $user = $this->getUser();
        $data = json_decode($request->getContent(), true);
        $education = new Education($data['degree'], new \DateTime($data['startDate']), new \DateTime($data['endDate']), $data['almaMater']);
        $education->setUser($user);
        $this->em->persist($education);
        $this->em->flush();
        return new JsonResponse(['success' => true]);
    }
}
