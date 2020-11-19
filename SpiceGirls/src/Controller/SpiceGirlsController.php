<?php

namespace App\Controller;

use App\Entity\Offers;
use App\Repository\OffersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
    public function add(Offers $offer)
    {
        $addOffer = new Offers();
        $form = $this->createFormBuilder($addOffer)->getForm()
            ->add("Titre", )
            ->add("Description")
            ->add("Contrat")
            ->add("Style de conrat")
            ->add("Adresse")
            ->add("Code Postal")
            ->add("Ville")
            ->add("Date de fin de contrat")
            ->add('Poster', SubmitType::class);

        dd($form);

        return $this->render('spice/add.html.twig', [
            'offer' => $offer,
            'form' => $form->createView(),
        ]);
    }
}

