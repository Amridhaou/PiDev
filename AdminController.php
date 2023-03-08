<?php

namespace App\Controller;

use App\Entity\Speciality;
use App\Entity\User;
use App\Form\AdminApproveType;
use App\Form\SpecialityType;
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
    #[Route('/listSpeciality', name: 'listSpeciality')]
    public function speciality(ManagerRegistry $doctrine): Response
    {
        $speciality= $doctrine->getRepository(Speciality::class)->findAll();
        return $this->render('backOffice/listSpeciality.html.twig', [
            'speciality' => $speciality,
        ]);
    }
    #[Route('deleteSpeciality/{id}', name: 'deleteSpeciality')]
    public function deleteSpeciality(ManagerRegistry $doctrine,$id): Response
    {
        $em= $doctrine->getManager();
        $S= $doctrine->getRepository(Speciality::class)->find($id);
        $em->remove($S);
        $em->flush();
        return $this->redirectToRoute('listSpeciality');
    }
    #[Route('addSpeciality', name: 'addSpeciality')]
    public function addSpeciality(ManagerRegistry $doctrine,Request $req): Response {
        $em = $doctrine->getManager();
        $speciality = new Speciality();
        $form = $this->createForm(SpecialityType::class,$speciality);
        $form->handleRequest($req);
        if($form->isSubmitted()){
            $em->persist($speciality);
            $em->flush();
            return $this->redirectToRoute('listSpeciality');
        }
        //$club->setName('club test persist');
        //$club->setCreationDate(new \DateTime());
        return $this->renderForm('backOffice/addSpeciality.html.twig',['form'=>$form]);
    }
    #[Route('updateSpeciality/{id}', name: 'updateSpeciality')]
    public function updateSpeciality(ManagerRegistry $doctrine,$id,Request $req): Response {
        $em = $doctrine->getManager();
        $speciality = $doctrine->getRepository(Speciality::class)->find($id);
        $form = $this->createForm(SpecialityType::class,$speciality);
        $form->handleRequest($req);
        if($form->isSubmitted()){
            $em->persist($speciality);
            $em->flush();
            return $this->redirectToRoute('listSpeciality');
        }
        return $this->renderForm('backOffice/addSpeciality.html.twig',['form'=>$form]);

    }
}
