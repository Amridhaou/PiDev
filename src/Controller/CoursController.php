<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Form\CoursType;
use App\Form\SendMailType;
use App\Repository\CoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cours')]
class CoursController extends AbstractController
{
    #[Route('/', name: 'cours_index', methods: 'GET')]
    public function ListCours(CoursRepository $coursRepository): Response
    {
        return $this->render('cours/index.html.twig', [
            'cours' => $coursRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'cours_new', methods: ['GET', 'POST'])]
    public function AddCours(Request $request, CoursRepository $coursRepository): Response
    {
        $course = new Cours();
        $form = $this->createForm(CoursType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $coursRepository->save($course, true);

            return $this->redirectToRoute('cours_index', []);
        }

        return $this->renderForm('cours/new.html.twig', [
            'cour' => $course,
            'form' => $form,
        ]);
    }

    #[Route('/{CodeCours}', name: 'cours_show', methods: 'GET')]
    public function ShowCours(Cours $course): Response
    {
        return $this->render('cours/show.html.twig', [
            'cour' => $course,
        ]);
    }

    #[Route('/{CodeCours}/edit', name: 'cours_edit', methods: ['GET', 'POST'])]
    public function EditCours(Request $request, Cours $course, CoursRepository $coursRepository): Response
    {
        $form = $this->createForm(CoursType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $coursRepository->save($course, true);

            return $this->redirectToRoute('cours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cours/edit.html.twig', [
            'cour' => $course,
            'form' => $form,
        ]);
    }

    #[Route('/{CodeCours}', name: 'cours_del', methods: ['POST'])]
    public function DeleteCours(Cours $course, CoursRepository $coursRepository): Response
    {
        $coursRepository->remove($course, true);
        return $this->redirectToRoute('cours_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{CodeCours}/email', name: 'sendMailToUser')]
    public function sendEmail(MailerInterface $mailer,Request $request,Cours $course): Response
    {
        $form =$this->createForm(SendMailType::class,null);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $message=$form->get('message')->getData();
            $subject=$form->get('subject')->getData();
            $email = (new Email())
                ->from('dhaou.amri@esprit.tn')
                ->to((string)$course->getContact())
                ->subject((string)$subject)
                ->text('Sending emails is fun again!')
                ->html("<p>$message</p>");
            $mailer->send($email);
            $this->addFlash('success', 'votre email a ete bien envoyé');
            return $this->redirectToRoute('cours_index');
        }
        return $this->render('admin/sendMail.html.twig', ['form' => $form->createView(),'user_email'=>$course->getContact()]);
    }
}
