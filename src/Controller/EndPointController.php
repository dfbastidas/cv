<?php

namespace App\Controller;

use App\Entity\Education;
use App\Entity\Experience;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user')]
final class EndPointController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    #[Route('/save-education', name: 'save_education')]
    public function saveEducation(Request $request): JsonResponse {
        $user = $this->getUser();
        $data = json_decode($request->getContent(), true);
        $education = new Education($data['degree'], new \DateTime($data['startEducationDate']), new \DateTime($data['endEducationDate']), $data['almaMater']);
        $education->setUser($user);
        $this->em->persist($education);
        $this->em->flush();
        return new JsonResponse(['success' => true]);
    }

    #[Route('/save-experience', name: 'save_experience')]
    public function saveExperience(Request $request): JsonResponse {
        $user = $this->getUser();
        $data = json_decode($request->getContent(), true);
        $experience = new Experience($data['role'], new \DateTime($data['startExperienceDate']), new \DateTime($data['endExperienceDate']), $data['description']);
        $experience->setUser($user);
        $this->em->persist($experience);
        $this->em->flush();
        return new JsonResponse(['success' => true]);
    }
}
