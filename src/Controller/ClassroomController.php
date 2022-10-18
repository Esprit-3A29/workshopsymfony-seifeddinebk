<?php

namespace App\Controller;
use App\Repository\ClassroomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Classroom;
use App\Form\AddClassroomType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;

class ClassroomController extends AbstractController
{
    #[Route('/classroom', name: 'app_classroom')]
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }

    

    #[Route('/list', name: 'list_classroom')]
    public function list(ClassroomRepository $repository):Response
        {
    
            $List=$repository->findAll();
    
        return $this->render('classroom/listClassroom.html.twig', [
         'tab_classroom' => $List,
     ]);
        }

    #[Route('/addClassroom', name: 'Add_Classroom')]
    public function addClassroom(Request $request ,ManagerRegistry $doctrine):Response
    {
        $Classroom = new Classroom();

        $form = $this->createForm(AddClassroomType::class, $Classroom);
        $entityManager = $doctrine->getManager();


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $Classroom = $form->getData();

            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entityManager->persist($Classroom);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();

            return $this->redirecttoroute('list_classroom');

        }
        return $this->render('classroom/AddClassroom.html.twig', [
            'Form' => $form->createView(),

        ]);
    }

        #[Route('/updateClassroom/{id}', name: 'Update_Classroom')]
    public function updateClassroom($id,Request $request ,ManagerRegistry $doctrine ,ClassroomRepository $repository):Response
        {
            $Classroom = $repository->find($id);

            $form = $this->createForm(AddClassroomType::class, $Classroom);
            $entityManager = $doctrine->getManager();


            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {


                $Classroom = $form->getData();

                // tell Doctrine you want to (eventually) save the Product (no queries yet)
                // $entityManager->persist($Classroom);

                // actually executes the queries (i.e. the INSERT query)
                $entityManager->flush();
                return $this->redirectToRoute('list_classroom');


            }
            return $this->render('classroom/AddClassroom.html.twig', [
                'Form' => $form->createView(),

            ]);

        }





    #[Route('/deleteClassroom/{id}', name: 'Delete_Classroom')]
    public function deleteClassroom($id,Request $request ,ManagerRegistry $doctrine ,ClassroomRepository $repository):Response
    {
        $Classroom = $repository->find($id);


        $entityManager = $doctrine->getManager();


        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->remove($Classroom);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        return $this->redirectToRoute('list_classroom');

    }


}
