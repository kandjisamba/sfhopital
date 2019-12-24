<?php

namespace App\Controller;

use App\Entity\Medcin;
use App\Entity\Service;
use App\Form\MedcinType;
use App\Repository\MedcinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MedcinController extends AbstractController
{
    /**
     * @Route("/medcin", name="medcin")
     */
    public function index()
    {
        return $this->render('medcin/index.html.twig', [
            'controller_name' => 'MedcinController',
        ]);
    }


      /**
     * @Route("/medcin/new", name="medcin_new")
     */
    public function new(Request $request)
    {

        $idMatricule = $this->getLastMedcin() + 1;  
        $medcin = new Medcin();
        $form = $this->createForm(MedcinType::class, $medcin);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            
            // $recup = $this->getDoctrine()->getManager();
            // $recup->persist($medcin);
            // $recup->flush();

            $twoFirstLetter =\strtoupper(\substr($medcin->getService()->getLibelle(),0,2));
            $longId = strlen((string)$idMatricule);
            $matricule = \str_pad("M".$twoFirstLetter,8 - $longId, "0").$idMatricule;
            $medcin->setMatricule($matricule);
            $recup = $this->getDoctrine()->getManager();
            $recup->persist($medcin);
            $recup->flush();
            $this->addFlash('success', 'Données créés avec succes');
            return $this->redirectToRoute('medcin_af');
        }
        return $this->render('medcin/new.html.twig', [
            //'medcin' => $medcin,
            'form' => $form->createView(),
            
        ]);
    }

        /**
     * @Route("/medcin/liste", name="medcin_af")
     */
    public function af_med()
    {
        $repo = $this->getDoctrine()->getRepository(Medcin::class);
        $af = $repo->findAll();
       
        return $this->render('medcin/af.html.twig', [
            'af' => $af
    
        ]);
    }

      /**
     * @Route("/medcin/edit{id}", name="medcin_edit")
     */
    public function af_edit($id, Request $request,MedcinRepository $repo)
    {
        $medcin = $repo->find($id);
        $form = $this->createForm(MedcinType::class, $medcin);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $recup = $this->getDoctrine()->getManager();
            $recup->persist($medcin);
            $recup->flush();
            return $this->redirectToRoute('medcin_af');
        }

        return $this->render('medcin/new.html.twig', [
            //'medcin' => $medcin,
            'form' => $form->createView()
        ]);
    }

   /**
     * @Route("/medcin/sup{id}", name="medcin_sup")
     */
    public function af_sup($id, Request $request,MedcinRepository $repo)
    {
        $medcin = $repo->find($id);
        $recup = $this->getDoctrine()->getManager();
        $recup->remove($medcin);
        $recup->flush();
        return $this->redirectToRoute('medcin_af');
       
    }

    public function getLastMedcin()
    {
        $ripo = $this->getDoctrine()->getRepository(Medcin::class);
        $medcinLast = $ripo->findBy([],['id'=>'DESC']);
        if($medcinLast == null)
        {
            return $id = 0;
        }
        else
        {
            return $medcinLast[0]->getId();
        }
    }
}
