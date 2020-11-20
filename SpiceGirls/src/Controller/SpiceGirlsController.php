<?php

namespace App\Controller;

use App\Entity\Offers;
use App\Entity\KindsContracts;
use App\Entity\TypesContracts;
use App\Repository\OffersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SpiceGirlsController extends AbstractController
{
    /**
     * @Route("/", name="spice")
     * @param OffersRepository $offersRepository
     */

    public function index(OffersRepository $offersRepository)
    {
        $offers = $offersRepository->findAll();
        return $this->render('spice/index.html.twig', [
            'offers' => $offers,
        ]);
    }

    /**
     * @Route("/posts/{id}", name="post")
     * @param Offers $offers
     */
    public function offer(Offers $offer, Request $request, EntityManagerInterface $entityManager)
    {
        return $this->render('spice/offer.html.twig', [
            'offer' => $offer,

        ]);
    }

    /**
     * @Route("/add", name="add")
     * @param Offers $offers
     */

    public function add(Request $request, EntityManagerInterface $entityManager)
    {

        $offernew = new Offers();
        $form = $this->createFormBuilder($offernew)
            ->add("Title",  TextType::class, [
                "attr" => ["class" => "form-control"]])

            ->add("Description", TextareaType::class, [
                "attr" => ["class" => "form-control"]])

            ->add("Address",  TextType::class, [
                "attr" => ["class" => "form-control"]])

            ->add("ZipCode",  TextType::class, [
                "attr" => ["class" => "form-control"]])

            ->add("City",  TextType::class, [
                "attr" => ["class" => "form-control"]])

            ->add("KindContract", ChoiceType::class, [
                'choices'  => [
                    'CDI' => 4,
                    'CDD' => 5,
                    'FREE' => 6,
                ],
                "attr" => ["class" => "form-control"]])

            ->add("typesContracts", ChoiceType::class, [
                'choices'  => [
                    'Temps plein' => 3,
                    'Temps partiel' => 4,
                ],
                "attr" => ["class" => "form-control"]])

            ->add("EndContract", DateType::class, [
                "attr" => ["class" => "my-2"]])

            ->add("submit", SubmitType::class, [
                "attr" => ["class" => "btn btn-primary mt-2"]])

            ->getForm();

        $offernew->setCreationDate(new \DateTime());


        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($offernew);
            $entityManager->flush();
        }

        return $this->render('spice/add.html.twig', [
            "form" => $form->createView()

        ]);


    }
}

