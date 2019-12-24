<?php

namespace App\Form;

use App\Entity\Medcin;
use App\Entity\Service;
use App\Entity\Specialite;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use App\Repository\ServiceRepository;
use App\Repository\SpecialiteRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class MedcinType extends AbstractType
{
    private $servRepo;
    private $speRepo;
    public function __construct(ServiceRepository $servRepo, SpecialiteRepository $speRepo)
    {
        $this->servRepo = $servRepo;
        $this->speRepo = $speRepo;

    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('matricule', HiddenType::class)
            ->add('prenom')
            ->add('nom')
            ->add('tel')
           ->add('datenais', DateType::class, [
            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd',
        ])
            ->add('service', EntityType::class,[
                'class' => Service::class,
                'choices' => $this->servRepo->findAll()
            ])
            ->add('specialites', EntityType::class,[
                'class' => Specialite::class,
                'choices' => $this->speRepo->findAll(),
                'multiple' => true,  
                'by_reference' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Medcin::class,
        ]);
    }
}
