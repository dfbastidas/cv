<?php

namespace App\Controller;

use App\Entity\CvTemplate;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/template')]
final class TemplateController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    #[Route('/list', name: 'template_list')]
    public function templateList(PaginatorInterface $paginator, Request $request): Response {
        $templates = $paginator->paginate(
            $this->em->getRepository(CvTemplate::class)->getCvTemplatesList(),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('template/list.html.twig', [
            'templates' => $templates
        ]);
    }

    #[Route('/view/{id}', name: 'view_templates')]
    public function viewTemplate(CvTemplate $cvTemplate, \Twig\Environment $twig) {
        $templateContent = $cvTemplate->getHtml();

        // Renderiza el Twig directamente sin cambiar el loader
        $renderedTemplate = $twig->createTemplate($templateContent)->render([
            'some_variable' => 'value',
        ]);

        return new Response($renderedTemplate);
    }
}
