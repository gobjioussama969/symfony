<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

// Lab 3 - I.9. Inheritance (Course Management Page)
final class CourseController extends AbstractController
{
    // Route used by the navbar (link "Courses")
    #[Route('/course', name: 'course_list')]
    public function list(): Response
    {
        $courses = [
            ['id' => 1, 'title' => 'Web Development with Symfony', 'semester' => 'S1'],
            ['id' => 2, 'title' => 'Advanced Symfony', 'semester' => 'S2'],
            ['id' => 3, 'title' => 'API Platform Fundamentals', 'semester' => 'S2'],
        ];

        return $this->render('course/list.html.twig', ['courses' => $courses]);
    }

    #[Route('/course/{id}', name: 'course_detail')]
    public function detail(int $id): Response
    {
        $course = [
            'id' => $id,
            'title' => 'Web Development with Symfony',
            'instructor' => ['name' => 'Dr. Wissem Eljaoued', 'email' => 'wissem@uni.tn'],
            'semester' => 'S1',
            'sessions' => [
                ['date' => new \DateTime('2025-10-01'), 'topic' => 'Introduction to Symfony'],
                ['date' => new \DateTime('2025-10-08'), 'topic' => 'Routing and Controllers'],
                ['date' => new \DateTime('2025-10-15'), 'topic' => 'Twig Templates'],
            ],
            'resources' => [
                ['title' => 'Symfony Documentation', 'url' => 'https://symfony.com/doc'],
                ['title' => 'Twig Reference', 'url' => 'https://twig.symfony.com/doc'],
            ],
        ];

        return $this->render('course/detail.html.twig', ['course' => $course]);
    }

    #[Route('/course/{id}/related', name: 'related_courses')]
    public function relatedCourses(int $id): Response
    {
        // Example related courses
        $related = [
            ['title' => 'Advanced Symfony', 'code' => 'SYM2'],
            ['title' => 'API Platform Fundamentals', 'code' => 'API1'],
        ];

        return $this->render('partials/_related_courses.html.twig', [
            'related_courses' => $related,
        ]);
    }
}
