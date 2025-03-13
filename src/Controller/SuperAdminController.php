<?php

namespace App\Controller;

use App\Entity\CvTemplate;
use App\Form\CreateTemplateType;
use App\Service\FileService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/super')]
final class SuperAdminController extends AbstractController
{

    private $em;
    private $fileService;


    public function __construct(EntityManagerInterface $em, FileService $fileService) {
        $this->em = $em;
        $this->fileService = $fileService;
    }

    #[Route('/create-template', name: 'create_template')]
    public function createTemplate(Request $request): Response {
        $cvTemplate = new CvTemplate();
        $form = $this->createForm(CreateTemplateType::class, $cvTemplate);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('thumbnail')->getData();
            $newFileName = $this->fileService->uploadFile($file, $_ENV['AWS_BUCKET_TEMPLATES_NAME']);
            $cvTemplate->setThumbnail($newFileName);
            $this->em->persist($cvTemplate);
            $this->em->flush();
            return $this->redirectToRoute('create_template');
        }
        return $this->render('super_admin/create-template.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/pre-view-template', name: 'pre_view_templates')]
    public function preViewTemplate () {
        return $this->render('super_admin/pre-view-template.html.twig');
    }

    #[Route('/view-template/{id}', name: 'view_templates')]
    public function viewTemplate(CvTemplate $cvTemplate, \Twig\Environment $twig) {
        $templateContent = $cvTemplate->getHtml();

        // Renderiza el Twig directamente sin cambiar el loader
        $renderedTemplate = $twig->createTemplate($templateContent)->render([
            'some_variable' => 'value',
        ]);

        return new Response($renderedTemplate);
    }


}
