<?php

namespace App\Controller;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\AddStudentType;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Student;
use ContainerGGuUppm\EntityManager_9a5be93;
use Symfony\Component\HttpFoundation\Request;


class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }
    #[Route('/listStudent', name: 'list_student')]
     public function listStudent(StudentRepository $repository): Response
    {

       $List=$repository->findAll();

        return $this->render('student/listStudent.html.twig', [
            'tab_student' => $List,
        ]);
    }
    #[Route('/AddStudent', name: 'Add_Student')]
    public function AddStudent(Request $request ,ManagerRegistry $doctrine ): Response
    {
        $Student = new Student();

        $form = $this->createForm(AddStudentType::class, $Student);
        $em = $doctrine->getManager();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $Student = $form->getData();
            $em->persist($Student);


            $em->flush();
            return $this->redirecttoroute('list_student');
        }
        return $this->render('student/AddStudent.html.twig', [
            'Form' => $form->createView(),

        ]);

       }
       #[Route('/AddStudent2', name: 'Add_Student2')]
       public function AddStudent2(StudentRepository $repository, Request $request ,ManagerRegistry $doctrine ): Response
       {
           $Student = new Student();
   
           $form = $this->createForm(AddStudentType::class, $Student);
           
           $form->handleRequest($request);
           if ($form->isSubmitted() && $form->isValid()) {
                $repository ->add($Student,TRUE);
                return $this->redirectToRoute('list_student');
           }
           return $this->render('student/AddStudent.html.twig', [
               'Form' => $form->createView(),
   
           ]);
   
          }
   


       #[Route('/UpdateStudent/{nce}', name: 'Update_Student')]

       public function UpdateStudent($nce,Request $request, ManagerRegistry  $doctrine , StudentRepository $repository):Response
       {
   
   
           $student = $repository->find($nce);
           $em = $doctrine->getManager();
           $form = $this->createForm(AddStudentType::class, $student);
           $form->handleRequest($request);
   
           if ($form->isSubmitted() && $form->isValid()) {
   
   
               $Student = $form->getData();
   
   
               $em->flush();
               return $this->redirecttoroute('list_student');
           }
           return $this->render('student/AddStudent.html.twig', [
               'Form' => $form->createView(),
   
           ]);
       }
   
       #[Route('/DeleteStudent/{nce}', name: 'Delete_Student')]
   
   
       public function DeleteStudent(StudentRepository $repository,$nce,ManagerRegistry $doctrine):Response {
   
           $student =$repository->find($nce);
           $em=$doctrine->getManager();
           $em->remove($student);
           $em->flush();
   
   
           return $this->redirectToRoute('list_student');
   
       }
   
   
   
   
}
