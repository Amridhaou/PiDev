<?php

namespace App\Controller;

use App\Entity\Certificat;
use App\Form\CertificatType;
use App\Repository\CertificatRepository;
use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/certificat')]
class CertificatController extends AbstractController
{
    #[Route('/', name: 'certificat_index', methods: ['GET'])]
    public function ListCertif(CertificatRepository $certificatRepository): Response
    {
        return $this->render('certificat/index.html.twig', [
            'certificats' => $certificatRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'certificat_new', methods: ['GET', 'POST'])]
    public function AddCertif(Request $request, CertificatRepository $certificatRepository): Response
    {
        $certificat = new Certificat();
        $form = $this->createForm(CertificatType::class, $certificat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $certificatRepository->save($certificat, true);

            return $this->redirectToRoute('certificat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('certificat/new.html.twig', [
            'certificat' => $certificat,
            'form' => $form,
        ]);
    }

    #[Route('/{Num_Certificat}', name: 'certificat_show', methods: ['GET'])]
    public function ShowCertif(Certificat $certificat): Response
    {
        return $this->render('certificat/show.html.twig', [
            'certificat' => $certificat,
        ]);
    }

    #[Route('/{Num_Certificat}/edit', name: 'certificat_edit', methods: ['GET', 'POST'])]
    public function EditCertif(Request $request, Certificat $certificat, CertificatRepository $certificatRepository): Response
    {
        $form = $this->createForm(CertificatType::class, $certificat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $certificatRepository->save($certificat, true);

            return $this->redirectToRoute('certificat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('certificat/edit.html.twig', [
            'certificat' => $certificat,
            'form' => $form,
        ]);
    }

    #[Route('/{Num_Certificat}', name: 'certificat_delete', methods: ['POST'])]
    public function DeleteCertif(Certificat $certificat, CertificatRepository $certificatRepository): Response
    {
        $certificatRepository->remove($certificat, true);
        return $this->redirectToRoute('certificat_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{Num_Certificat}/pdf', name: 'pdf_generator')]
    public function PDFCertif(Certificat $certificat): Response
    {
        $html =  $this->renderView('certificat/pdf.html.twig', ['certificat'=>$certificat]);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();

        return new Response (
            $dompdf->stream('resume', ["Attachment" => false]),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        );
    }
}
