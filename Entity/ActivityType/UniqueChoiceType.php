<?php

namespace Innova\ActivityBundle\Entity\ActivityType;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Innova\ActivityBundle\Entity\ActivityProperty\ChoiceProperty;

/**
 * Unique Choice type
 * An activity where the response is a unique choice into a list of possible responses
 *
 * @ORM\Table(name="innova_activity_type_unique")
 * @ORM\Entity
 */
class UniqueChoiceType extends AbstractChoiceType
{
    /**
     * Unique identifier of the type
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * List of choices of the Activity
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Innova\ActivityBundle\Entity\ActivityProperty\ChoiceProperty")
     * @ORM\JoinTable(
     *      name               = "innova_activity_type_unique_choices",
     *      joinColumns        = { @ORM\JoinColumn(name="type_id",   referencedColumnName="id") },
     *      inverseJoinColumns = { @ORM\JoinColumn(name="choice_id", referencedColumnName="id", unique=true) }
     * )
     */
    protected $choices;

    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->choices = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get all choices
     * @return ArrayCollection
     */
    public function getChoices()
    {
        return $this->choices;
    }

    /**
     * Add a choice to the list of choices
     * @param ChoiceProperty $choice
     * @return AbstractChoiceType
     */
    public function addChoice(ChoiceProperty $choice)
    {
        if (!$this->choices->contains($choice)) {
            $this->choices->add($choice);
        }

        return $this;
    }

    /**
     * Remove a choice from the list of choices
     * @param ChoiceProperty $choice
     * @return AbstractChoiceType
     */
    public function removeChoice(ChoiceProperty $choice)
    {
        if ($this->choices->contains($choice)) {
            $this->choices->removeElement($choice);
        }

        return $this;
    }
}
