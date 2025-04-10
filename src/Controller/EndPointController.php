<?php

namespace App\Controller;

use App\Entity\Education;
use App\Entity\Experience;
use App\Entity\Link;
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

    #[Route('/delete-education/{id}', name: 'delete_education', methods: ['DELETE'])]
    public function deleteEducation(Education $education) {
        $user = $this->getUser();
        if ($education->getUser() == $user) {
            $this->em->remove($education);
            $this->em->flush();
            return new JsonResponse(['success' => true]);
        }
        return new JsonResponse(['success' => false]);
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

    #[Route('/delete-experience/{id}', name: 'delete_experience', methods: ['DELETE'])]
    public function deleteExperience(Experience $experience): JsonResponse {
        $user = $this->getUser();
        if ($experience->getUser() === $user) {
            $this->em->remove($experience);
            $this->em->flush();
            return  new JsonResponse(['success' => true]);
        }
        return new JsonResponse(['success' => false]);
    }

    #[Route('/save-link', name: 'save_link')]
    public function saveLink(Request $request): JsonResponse {
        $user = $this->getUser();
        $data = json_decode($request->getContent(), true);
        $link = new Link($data['label'], $data['link'], $user);
        $this->em->persist($link);
        $this->em->flush();
        return new JsonResponse(['success' => true]);
    }

    #[Route('/get-links', name: 'get_links')]
    public function getLinks(): JsonResponse {
        $user = $this->getUser();
        $links = $this->em->getRepository(Link::class)->getUserLink($user);
        return  new JsonResponse($links);
    }

    #[Route('/delete-link/{id}', name: 'delete_link', methods: ['DELETE'])]
    public function deleteLink(Link $link): JsonResponse {
        $user = $this->getUser();
        if ($user == $link->getUser()) {
            $this->em->remove($link);
            $this->em->flush();
            return  new JsonResponse(['success' => true]);
        }
        return new JsonResponse(['success' => false]);
    }
}
