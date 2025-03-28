<?php

namespace App\Controller;

use App\Entity\CvTemplate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Snappy\Pdf;

final class HtmlToPdfController extends AbstractController
{
    #[Route('/html/to/pdf/{id}', name: 'html_to_pdf')]
    public function index(CvTemplate $cvTemplate, Pdf $knpSnappyPdf, \Twig\Environment $twig): Response {
        $templateContent = $cvTemplate->getHtml();

        // Renderiza el Twig directamente sin cambiar el loader
        $renderedTemplate = $twig->createTemplate($templateContent)->render([
            'some_variable' => 'value',
        ]);

        // Generar PDF
        $pdf = $knpSnappyPdf->getOutputFromHtml($renderedTemplate,  [
            'page-width' => $cvTemplate->getPageWidth(),
            'page-height' => $cvTemplate->getPageHeight(),
            'margin-top' => '0mm',
            'margin-right' => '0mm',
            'margin-bottom' => '0mm',
            'margin-left' => '0mm'
        ]);

        return new Response(
            $pdf,
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="curriculum.pdf"'
            ]
        );
    }
}
