<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Patient;
use AppBundle\Entity\Hospital;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


/**
 * @Route("/patient")
 */
class PatientController extends Controller
{
    /**
     * @Route("/index")
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Patient:index.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/add", name="patient_page")
     */
    public function addAction(Request $request) {
        // When a method to manage a form submission, it must use a request object


        // create an object patient
        $patient = new Patient();

        // create a form
        $form = $this->createFormBuilder($patient)
            ->add('name', TextType::class, array())
            ->add('hospital', EntityType::class, array(
                'class' => 'AppBundle:Hospital',
                'choice_label' => 'name'
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Enregistrer'
            ))
            ->getForm();

        // connect a form object with a request object
        $form->handleRequest($request);

        // submission a form
        if ($form->isSubmitted() == 'POST') {

            // hydration
            $patient = $form->getData();

            // registration in DB
            $em = $this->getDoctrine()->getManager();

            // preparation
            $em->persist($patient);

            // execution
            $em->flush();
        }




        return $this->render('AppBundle:Patient:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

}
