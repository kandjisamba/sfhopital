<?php

namespace App\Form;

use App\Entity\Medcin;
use App\Entity\Service;
use App\Entity\Specialite;
use App\Repository\MedcinRepository;
use App\Repository\ServiceRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpecialiteType extends AbstractType
{
    private $servRepo;
    private $speRepo;
    public function __construct(ServiceRepository $servRepo, MedcinRepository $medRepo)
    {
        $this->servRepo = $servRepo;
        $this->medRepo = $medRepo;

    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle')
           ->add('medcin', EntityType::class,[
            'class' => Medcin::class,
            'choices' => $this->medRepo->findAll(),
            'multiple' => true,  
            'by_reference' => false
        ])
            ->add('service', EntityType::class,[
                'class' => Service::class,
                'choices' => $this->servRepo->findAll()
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Specialite::class,
        ]);
    }
}
