<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Form\SearchCategoryType;
use App\Form\SearchEventType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/event')]
final class EventController extends AbstractController
{
    // IV.4. Read
    #[Route('/', name: 'app_event')]
    public function events(EventRepository $er): Response
    {
        $events = $er->findAll();
        return $this->render('event/list.html.twig', [
            'events' => $events,
        ]);
    }

    // IV.5. Add
    #[Route('/new', name: 'app_event_new')]
    public function new(Request $r, EntityManagerInterface $em): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($r);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($event);
            $em->flush();
            return $this->redirectToRoute('app_event');
        }
        return $this->render('event/new.html.twig', ['form' => $form->createView()]);
    }

    //Search Event by name (IV.9. DQL)
    #[Route('/events/search', name: 'event_search')]
    public function search(Request $request, EventRepository $eventRepository): Response
    {
        $form = $this->createForm(SearchEventType::class);
        $form->handleRequest($request);

        $events = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $events = $eventRepository->searchByName($data['name'] ?? '');
        }

        return $this->render('event/search.html.twig', [
            'form' => $form->createView(),
            'events' => $events,
        ]);
    }

    //Search Events by Category (IV.9. DQL - TO DO)
    #[Route('/events/searchByCategory', name: 'event_search_category')]
    public function searchByCategory(Request $request, EventRepository $eventRepository): Response
    {
        $form = $this->createForm(SearchCategoryType::class);
        $form->handleRequest($request);

        $events = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $events = $eventRepository->searchByCategory($data['category'] ?? '');
        }

        return $this->render('event/searchByCategory.html.twig', [
            'form' => $form->createView(),
            'events' => $events,
        ]);
    }

    // IV.7. Update
    #[Route('/{id}/edit', name: 'app_event_update')]
    public function edit(Request $r, $id, EventRepository $er, EntityManagerInterface $em): Response
    {
        $event = $er->find($id);

        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($r);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($event);
            $em->flush();
            return $this->redirectToRoute('app_event');
        }

        return $this->render('event/edit.html.twig', ['form' => $form->createView()]);
    }

    // IV.6. Delete
    #[Route('/{id}', name: 'app_event_delete')]
    public function delete($id, EventRepository $er, EntityManagerInterface $em): Response
    {
        $event = $er->find($id);
        $em->remove($event);
        $em->flush();
        return $this->redirectToRoute('app_event');
    }
}
