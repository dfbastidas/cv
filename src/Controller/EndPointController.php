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

    #[Route('/get-education', name: 'get_education')]
    public function getEducation(): JsonResponse {
        $user = $this->getUser();
        $education = $this->em->getRepository(Education::class)->getUserEducation($user);
        return new JsonResponse($education);
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

    #[Route('/get-experience', name: 'get_experience')]
    public function getExperience(): JsonResponse {
        $user = $this->getUser();
        $experience = $this->em->getRepository(Experience::class)->getUserExperience($user);
        return  new JsonResponse($experience);
    }
}
