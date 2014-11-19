<?php

namespace Innova\ActivityBundle\Manager;

use Innova\ActivityBundle\Entity\AbstractActivity;
/*use Innova\ActivityBundle\Entity\ActivitySequence;
use Innova\ActivityBundle\Entity\ActivityVF;*/
use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service("innova.manager.activity_sequence_manager")
 */
class ActivitySequenceManager
{
    /**
    * @DI\InjectParams({
    *   "container" = @DI\Inject("service_container"),
    *   "em" = @DI\Inject("doctrine.orm.entity_manager"),
    * })
    */
    public function __construct($container, $em)
    {
        $this->container = $container;
        $this->em = $em;
    }

    public function countActivities(ActivitySequence $activitySequence){
        if(!$count = $activitySequence->getActivities()){
            $count = 1;
        }

        return count($count) + 1;
    }

    public function addActivity(ActivitySequence $activitySequence){

//        $activityType = "ActivityVF"; // For tests. Eric.
//        $activity = $this->createActivity($activitySequence, $activityType);
        $activity = $this->createActivity($activitySequence);

        return $activity;
    }

//    public function createActivity(ActivitySequence $activitySequence, $activityType)
    public function createActivity(ActivitySequence $activitySequence)
     {

//        $activityType = "ActivityVF";

//        $activity = $this->em->factory('Innova\ActivityBundle\Entity\\' . $activityType);
        $activity = new ActivityVF;
        $activity->setName("New Activity");
        $activity->setDescription("New Description");
        $activity->setActivitySequence($activitySequence);
//        $activity->setOrder($this->countActivities($activitySequence));
        $this->em->persist($activity);
        $this->em->flush();

        return $activity;
    }

    public function deleteActivity(AbstractActivity $activity) {
        $activitySequence = $activity->getActivitySequence();
        $this->em->remove($activity);
        $this->em->flush();

        $this->reorderActivitySequence($activitySequence);

        return $activitySequence;
    }

    public function reorderActivitySequence(ActivitySequence $activitySequence){
        if ($activities = $activitySequence->getActivities() ) {
            $i = 1;
            foreach ($activities as $activity) {
                $activity->setOrder($i);
                $this->em->persist($activity);
                $i++;
            }
            $this->em->flush();
        }
    }

    public function activitySequenceToJson(ActivitySequence $activitySequence)
    {
        $activitySequenceActivities = array ();
        if ($activities = $activitySequence->getActivities() ) {
            foreach ($activities as $activity) {
                $activitySequenceActivities[] = array (
                                                    "id" => $activity->getId(),
                                                    "name" => $activity->getName(),
                                                    "order" => $activity->getOrder()
                );
            }
        }

        $activitySequenceAttrs = array (
            "id"         => $activitySequence->getId(),
            "name"       => $activitySequence->getResourceNode()->getName(),
            "activities" => $activitySequenceActivities,
        );

        return json_encode($activitySequenceAttrs);
    }


    public function activityAttrs(AbstractActivity $activity)
    {
        $activityAttrs = array (
                            "id" => $activity->getId(),
                            "name" => $activity->getName(),
                            "order" => $activity->getOrder()
        );

        return $activityAttrs;
    }

    public function applyOrder(ActivitySequence $activitySequence, $order)
    {
        $i=1;
        $order = json_decode($order);
        foreach ($order as $activityId) {
            $activity = $this->em->getRepository('InnovaActivityBundle:Activity')->find($activityId);
            $activity->setOrder($i);
            $this->em->persist($activity);
            $i++;
        }
        $this->em->flush();

        return $activitySequence;
    }
}
