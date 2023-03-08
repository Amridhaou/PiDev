<?php

namespace App\Controller;

use App\Entity\Speciality;
use App\Entity\User;
use App\Form\AdminApproveType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/homeAdmin', name: 'homeAdmin')]
    public function homeAdmin(): Response
    {
        return $this->render('backOffice/home.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    #[Route('/listEnseignant', name: 'listEnseignant')]
    public function listEnseignant(ManagerRegistry $doctrine): Response
    {


        $user= $doctrine->getRepository(User::class)->findAll();
        return $this->render('backOffice/listEnseignant.html.twig', [
            'user' => $user,

        ]);
    }
    #[Route('/listEtudiant', name: 'listEtudiant')]
    public function listEtudiant(ManagerRegistry $doctrine): Response
    {


        $user= $doctrine->getRepository(User::class)->findAll();
        return $this->render('backOffice/listEtudiant.html.twig', [
            'user' => $user,

        ]);
    }
    #[Route('deleteUser/{id}', name: 'deleteUser')]
    public function deleteUser(ManagerRegistry $doctrine,$id): Response
    {
        $em= $doctrine->getManager();
        $S= $doctrine->getRepository(User::class)->find($id);
        $em->remove($S);
        $em->flush();
        return $this->redirectToRoute('homeAdmin');
    }
    #[Route('adminApprove/{id}', name: 'adminApprove')]
    public function adminApprove(ManagerRegistry $doctrine,$id,Request $req): Response
    {
        $em = $doctrine->getManager();
        $user = $doctrine->getRepository(User::class)->find($id);
        $users = $doctrine->getRepository(User::class)->find($id);
        $form = $this->createForm(AdminApproveType::class,$user);
        $form->handleRequest($req);
        if($form->isSubmitted()){
            $em->persist($user);
            $em->flush();
            $roles=$user->getRoles();

            return $this->redirectToRoute('listEnseignant');

        }
        return $this->renderForm('backOffice/adminApprove.html.twig',[
            'users' => $users,
            'form'=>$form
        ]);

    }
}
