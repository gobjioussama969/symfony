<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\Student;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class StudentController extends AbstractController
{
    // ===================== Lab 2 : Routing + Controller =====================

    // I.1. Return a Response
    #[Route('/student', name: 'app_student')]
    public function index(): Response
    {
        return new Response("Hello Students");
    }

    // I.2. Response object
    // I.4. To do (1) : an id must be an integer (2 digits)
    #[Route('/student/{id}', name: 'show_student', requirements: ['id' => '\d{2}'])]
    public function showStudent($id): Response
    {
        return new Response("Hello Student number: " . $id);
    }

    //Students List (Lab 3 - I.2 / I.5)
    #[Route('/student/list', name: 'student_list', priority: 2)]
    public function listStudent(): Response
    {
        $students = ["Ali", "Med", "Louay"];
        $courses = [
            ["id" => 1,
                "course" => "Symfony",
                "Hours" => 42,
                "teacher" => "Ali"],
            ["id" => 2,
                "course" => "Spring Boot",
                "Hours" => 42,
                "teacher" => "Med"],
            ["id" => 3,
                "course" => "UML",
                "Hours" => 42,
                "teacher" => "Mayssa"]
        ];
        return $this->render('student/list.html.twig',
            ["students" => $students, "courses" => $courses]);
    }

    // I.3. Return a message using the View (twig)
    #[Route('/student/{name}', name: 'show_student_name')]
    public function showName($name): Response
    {
        return $this->render('student/student.html.twig', ["name" => $name]);
    }

    // I.4. To do (2) : login
    // - login : only numbers and letters, the first one must be capitalized
    // - password : default value "guest"
    #[Route('/login/{login}/{password}', name: 'login',
        requirements: ['login' => '[A-Z][a-zA-Z0-9]*'],
        defaults: ['password' => 'guest'])]
    public function login($login, $password): Response
    {
        return $this->render('student/login.html.twig', [
            "login" => $login,
            "password" => $password,
        ]);
    }

    // I.4. To do (3) : sum of marks (mark1 and mark2 should be numbers)
    #[Route('/student/{mark1}/{mark2}', name: 'sum',
        requirements: ['mark1' => '\d+(\.\d+)?', 'mark2' => '\d+(\.\d+)?'])]
    public function sum($mark1, $mark2): Response
    {
        $sum = $mark1 + $mark2;
        return new Response("The sum of " . $mark1 . " and " . $mark2 . " is: " . $sum);
    }

    // I.5. Redirect : Internal Route
    // Redirect to student
    #[Route('/Hello', name: 'student_Hello')]
    public function hello(): Response
    {
        // Redirect to the route "app_student"
        return $this->redirectToRoute('app_student');
    }

    // I.5. Redirect : External URL
    // Redirection to an external URL
    #[Route('/documentation', name: 'student_docs')]
    public function docs(): Response
    {
        // Redirect to an external web site (ex : Symfony documentation)
        return $this->redirect('https://symfony.com/doc/current/index.html');
    }

    // I.6. Generate URL
    // Redirection to a specific student
    #[Route('/student/redirect/{id}', name: 'student_redirect')]
    public function redirectToStudent(int $id): Response
    {
        // Génération de l'URL et redirection
        $url = $this->generateUrl('show_student', ['id' => $id]);
        return $this->redirect($url);
    }

    // ===================== Lab 3 : Template TWIG =====================

    //Assignment
    #[Route('/assignment', name: 'assignment')]
    public function assignment(): Response
    {
        return $this->render('student/assignment.html.twig');
    }

    // I.8. Students List (Objects)
    #[Route('/students', name: 'students')]
    public function students(): Response
    {
        // array of students (array of objects)
        $students = [
            new Student(1, "Ali", 20),
            new Student(2, "Med", 21),
            new Student(3, "Louay", 22),
        ];

        // array of courses (array of objects)
        $courses = [
            new Course(1, "Symfony"),
            new Course(2, "Spring Boot"),
            new Course(3, "UML"),
        ];

        // assign all students to all courses
        foreach ($courses as $course) {
            foreach ($students as $student) {
                $course->addStudent($student);
            }
        }

        return $this->render('student/students.html.twig', [
            "students" => $students,
            "courses" => $courses,
        ]);
    }
}
