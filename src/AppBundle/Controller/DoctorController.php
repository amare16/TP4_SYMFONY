<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Doctor;
use Symfony\Component\Form\Extension\Core\Type\TextType; // to insert the type of input
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


/**
 * @Route("/doctor")
 */

class DoctorController extends Controller
{
    /**
     * @Route("/index", name="doctor_index")
     */
    public function indexAction() {

        $doctors = $this->getDoctrine()
            ->getRepository(Doctor::class)->findAll();


        return $this->render('AppBundle:Doctor:index.html.twig', array(
           'doctors' => $doctors
        ));
    }

    /**
     * @Route("/add")
     */
    public function addAction(Request $request) {

        // When a method to manage a form submission, it must use a Request object

        // create an object called doctor

        $doctor = new Doctor();

        // create a form

        $form = $this->createFormBuilder($doctor)
            ->add('name', TextType::class)
            ->add('submit', SubmitType::class, array(
                'label' => "Enregistrer"
            ))
            ->getForm();

        // connect an object $form with an object $request

        $form->handleRequest($request);

        // form submission

        if ($form->isSubmitted() == 'POST') {

            // hydration
            $doctor = $form->getData();

            // registration on database

            $em = $this->getDoctrine()->getManager();

            // prepares the insert request but does not execute any SQL queries
            $em->persist($doctor);

            // execute all pending SQL queries
            $em->flush();

            return $this->redirectToRoute('doctor_index');

        }


        return $this->render('AppBundle:Doctor:add.html.twig', array(
           'form' => $form->createView()
        ));
    }

    /**
     * @Route("/edit")
     */
    public function editAction()
    {
        return $this->render('AppBundle:Doctor:edit.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/delete")
     */
    public function deleteAction()
    {
        return $this->render('AppBundle:Doctor:delete.html.twig', array(
            // ...
        ));
    }

}
