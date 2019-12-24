<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Entity\Specialite;
use App\Form\SpecialiteType;
use App\Repository\ServiceRepository;
use App\Repository\SpecialiteRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{

       /**
     * @Route("/admin/adserv", name="ads")
     */
    public function ads(Request $request)
    {
         $service = new Service(); 
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            
            $recup = $this->getDoctrine()->getManager();
            $recup->persist($service);
            $recup->flush();
            return $this->redirectToRoute('afs');
        }
        return $this->render('admin/ads.html.twig', [
            
            'form' => $form->createView(),
            
            ]);
    }

    
  /**
     * @Route("/admin/edits{id}", name="edit")
     */
    public function edits($id, Request $request,ServiceRepository $repo)
    {
         $service = $repo->find($id); 
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            
            $recup = $this->getDoctrine()->getManager();
            $recup->persist($service);
            $recup->flush();
            return $this->redirectToRoute('afs');
        }
        return $this->render('admin/ads.html.twig', [
            
            'form' => $form->createView(),
            
            ]);
    }


/**
     * @Route("/admin/sup{id}", name="sup")
     */
    public function af_sup($id, Request $request,ServiceRepository $repo)
    {
        $id!== null;
        $service = $repo->find($id);
        $recup = $this->getDoctrine()->getManager();
        $recup->remove($service);
        $recup->flush();
        return $this->redirectToRoute('afs');
       
    }

    /**
     * @Route("/admin/afserv", name="afs")
     */
    public function show_service(ServiceRepository $repo)
    {
        $services = $repo->findAll(); 
        return $this->render('admin/afs.html.twig', [
            'services' => $services,
        ]);
    }
    



  /**
     * @Route("/admin/adsp", name="adsp")
     */
    public function adsp(Request $request)
    {
         $specialite = new Specialite(); 
        $form = $this->createForm(SpecialiteType::class, $specialite);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            
            $recup = $this->getDoctrine()->getManager();
            $recup->persist($specialite);
            $recup->flush();
            return $this->redirectToRoute('afsp');
        }
        return $this->render('admin/adsp.html.twig', [
            
            'form' => $form->createView(),
            
            ]);
    }

    
  /**
     * @Route("/admin/editsp/{id}", name="editp")
     */
    public function editsp($id, Request $request,SpecialiteRepository $repo)
    {
        $specialite = $repo->find($id); 
        $form = $this->createForm(SpecialiteType::class, $specialite);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            
            $recup = $this->getDoctrine()->getManager();
            $recup->persist($specialite);
            $recup->flush();
            return $this->redirectToRoute('afsp');
        }
        return $this->render('admin/adsp.html.twig', [
            
            'form' => $form->createView(),
            
            ]);
    }


/**
     * @Route("/admin/supp/{id}", name="supp")
     */
    public function sp_sup($id, Request $request,SpecialiteRepository $repo)
    {
        
        $specialite = $repo->find($id);
        $recup = $this->getDoctrine()->getManager();
        $recup->remove($specialite);
        $recup->flush();
        return $this->redirectToRoute('afsp');
       
    }

    /**
     * @Route("/admin/afsp", name="afsp")
     */
    public function show_specialite(SpecialiteRepository $repo)
    {
        $specialite = $repo->findAll(); 
        return $this->render('admin/afsp.html.twig', [
            'specialite' => $specialite,
        ]);
    }

  /**
     * @Route("/admin/hopital", name="hopital")
     */
    public function hopital()
    {
        
        return $this->render('admin/hopital.html.twig');
    }

}
