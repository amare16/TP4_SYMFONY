<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hospital
 *
 * @ORM\Table(name="hospital")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HospitalRepository")
 */
class Hospital
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="specialization", type="string", length=255)
     */
    private $specialization;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)`
     */
    private $city;


    /**
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Doctor")
     *
     */
    private $doctor;


    /**
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Patient", mappedBy="hospital")
     *
     */
    private $patients;



    /**
     * Get id
     *
     * @return int
     */


    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Hospital
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set specialization
     *
     * @param string $specialization
     *
     * @return Hospital
     */
    public function setSpecialization($specialization)
    {
        $this->specialization = $specialization;

        return $this;
    }

    /**
     * Get specialization
     *
     * @return string
     */
    public function getSpecialization()
    {
        return $this->specialization;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Hospital
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set doctor
     *
     * @param \AppBundle\Entity\Doctor $doctor
     *
     * @return Hospital
     */
    public function setDoctor(\AppBundle\Entity\Doctor $doctor = null)
    {
        $this->doctor = $doctor;

        return $this;
    }

    /**
     * Get doctor
     *
     * @return \AppBundle\Entity\Doctor
     */
    public function getDoctor()
    {
        return $this->doctor;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->patients = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add patient
     *
     * @param \AppBundle\Entity\Patient $patient
     *
     * @return Hospital
     */
    public function addPatient(\AppBundle\Entity\Patient $patient)
    {
        $this->patients[] = $patient;

        return $this;
    }

    /**
     * Remove patient
     *
     * @param \AppBundle\Entity\Patient $patient
     */
    public function removePatient(\AppBundle\Entity\Patient $patient)
    {
        $this->patients->removeElement($patient);
    }

    /**
     * Get patients
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPatients()
    {
        return $this->patients;
    }
}
