<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\EventRepository;
use App\Repository\RegistrationRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(EventRepository $er, CategoryRepository $cr, RegistrationRepository $rr, UserRepository $ur): Response
    {
        $events = $er->findBy([], ['startDate' => 'ASC'], 3);

        return $this->render('home/index.html.twig', [
            'events' => $events,
            'nbEvents' => count($er->findAll()),
            'nbCategories' => count($cr->findAll()),
            'nbRegistrations' => count($rr->findAll()),
            'nbUsers' => count($ur->findAll()),
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('home/contact.html.twig');
    }
}