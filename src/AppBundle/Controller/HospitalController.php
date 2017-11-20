<?php

namespace AppBundle\Controller;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Hospital;
use AppBundle\Entity\Doctor;
use Symfony\Component\Form\Extension\Core\Type\TextType; // to insert the type of input






/**
 * @Route("/hospitals")
 */


class HospitalController extends Controller
{
    /**
     * @Route("/", name="hospital_admin_page")
     */
    public function indexAction(Request $request) {

        //var_dump($request);

        $post = $request->request;


        //
        if ($request->getMethod() == 'POST') {
            $name = $post->get('name');
            $specialization = $post->get('specialization');
            $city = $post->get('city');
            $doctor_id = $post->get('doctor_id');


            // get the complete producer object from an id
            $doctor = $this->getDoctrine()
                ->getRepository(Doctor::class)->find($doctor_id);



            // create an object $hospital

            $hospital = new Hospital();

            // hydration

            $hospital->setName($name);
            $hospital->setSpecialization($specialization);
            $hospital->setCity($city);
            $hospital->setDoctor($doctor);

            // using EntityManager

            $em = $this->getDoctrine()->getManager();

            // prepares the insert request but does not execute any SQL queries
            $em->persist($hospital);

            // execute all pending SQL queries
            $em->flush();


        }

            $hospitals = $this
                ->getDoctrine()
                ->getRepository(Hospital::class)
                ->findAll();

            $doctors = $this
                ->getDoctrine()
                ->getRepository(Doctor::class)
                ->findAll();




        return $this->render('AppBundle:Hospital:index.html.twig', array(
            'hospitals' => $hospitals,
            'doctors' => $doctors
        ));


    }


    /**
     * @Route("/delete{id}", name="hospital_delete")
     */
    public function deleteAction($id) {
        // the argument $ id corresponds to the parameter {id} defined at the level of the @Route annotation


        $hospital = $this->getDoctrine()->getRepository(Hospital::class)->find($id);
        $em = $this->getDoctrine()->getManager();

        // pending deletion request
        $em->remove($hospital);

        // execute pending SQL queries
        $em->flush();


        return $this->redirectToRoute('hospital_admin_page');

    }

    /**
     * @Route("/update/{id}", name="hospital_update")
     */
    public function updateAction($id, Request $request) {
        // the argument $ id corresponds to the parameter {id} defined at the level of the @Route annotation

        // Calling getRepository from getManager establishes a connection,
        // a "visibility" between the repo and the manager here,
        // the manager "knows", is notified of the existence of the fruit object,
        // if this object changes (receives new values) the manager knows it. The manager "monitors" this object.

        $em = $this->getDoctrine()->getManager();
        $hospital= $em->getRepository(Hospital::class)->find($id);

        if ($request->getMethod() == 'POST') {
            $hospital->setName($request->request->get('name'));
            $hospital->setSpecialization($request->request->get('specialization'));
            $hospital->setCity($request->request->get('city'));

            $em->flush();


            return $this->redirectToRoute('hospital_admin_page');
        }





        return $this->render('AppBundle:Hospital:update.html.twig', array(
            'hospital' => $hospital
        ));
    }

}
