<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\EventRepository;
use App\Repository\RegistrationRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

// Lab 4 - IV.10 : the admin (ROLE_ADMIN) is redirected to his dashboard after login
#[IsGranted('ROLE_ADMIN')]
final class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(EventRepository $er, CategoryRepository $cr, UserRepository $ur, RegistrationRepository $rr): Response
    {
        return $this->render('dashboard/index.html.twig', [
            'nbEvents' => count($er->findAll()),
            'nbCategories' => count($cr->findAll()),
            'nbUsers' => count($ur->findAll()),
            'nbRegistrations' => count($rr->findAll()),
        ]);
    }
}
