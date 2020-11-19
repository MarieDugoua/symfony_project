<?php

namespace App\Controller;

use App\Entity\Offers;
use App\Repository\OffersRepository;
use Doctrine\ORM\EntityManagerInterface;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;

class SpiceGirlsController extends AbstractController
{
    /**
     * @Route("/spice", name="spice")
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
     * @Route("/offer/{id}", name="offer")
     * @param Offers $offers
     */
    public function offer(Offers $offer)
    {
        return $this->render('spice/offer.html.twig', [
            'offer' => $offer,

        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function add(Offers $offer, Request $request, EntityManagerInterface $em)
    {
        $addOffer = new Offers();
        $form = $this->createFormBuilder($addOffer)->getForm()
            ->add("Titre", TextType::class, [
                "attr" => ["class" => "form-control"]
            ])
            ->add("Description", TextareaType::class, [
                "attr" => ["class" => "form-control"]
            ])
            ->add("Contrat")
            ->add("Type de conrat")
            ->add("Adresse", TextareaType::class, [
                "attr" => ["class" => "form-control"]
            ])
            ->add("Code Postal", TextareaType::class, [
                "attr" => ["class" => "form-control"]
            ])
            ->add("Ville", TextareaType::class, [
                "attr" => ["class" => "form-control"]
            ])
            ->add("Date de fin de contrat", DateType::class, [
                "attr" => ["class" => "form-control"]
            ])
            ->add('Poster', SubmitType::class, [
                "attr" => ["class" => "btn btn-outline-primary"]
            ])
            ->getForm();

        $addOffer->setCreationDate(new \DateTime());
        $addOffer->setUpdateDate(new \DateTime());
        $addOffer->setOffers($offer);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em->persist($addOffer);
            $em->flush();
        }

        return $this->render('spice/add.html.twig', [
            'offer' => $offer,
            'form' => $form->createView(),
        ]);
    }
}

