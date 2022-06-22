<?php

namespace AppBundle\Topic;

use Gos\Bundle\WebSocketBundle\Router\WampRequest;
use Gos\Bundle\WebSocketBundle\Topic\TopicInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Wamp\Topic;

class GpioTopic implements TopicInterface
{
    /**
     * This will receive any Subscription requests for this topic.
     *
     * @param ConnectionInterface $connection
     * @param Topic $topic
     * @param WampRequest $request
     * @return void
     */
    public function onSubscribe(ConnectionInterface $connection, Topic $topic, WampRequest $request)
    {
        //this will broadcast the message to ALL subscribers of this topic.
        $topic->broadcast(['msg' => $connection->resourceId . " has joined " . $topic->getId()]);
    }

    /**
     * This will receive any UnSubscription requests for this topic.
     *
     * @param ConnectionInterface $connection
     * @param Topic $topic
     * @param WampRequest $request
     * @return voids
     */
    public function onUnSubscribe(ConnectionInterface $connection, Topic $topic, WampRequest $request)
    {
        //this will broadcast the message to ALL subscribers of this topic.
        $topic->broadcast(['msg' => $connection->resourceId . " has left " . $topic->getId()]);
    }

    /**
     * This will receive any Publish requests for this topic.
     *
     * @param ConnectionInterface $connection
     * @param $Topic topic
     * @param WampRequest $request
     * @param $event
     * @param array $exclude
     * @param array $eligibles
     * @return mixed|void
     */
    public function onPublish(ConnectionInterface $connection, Topic $topic, WampRequest $request, $event, array $exclude, array $eligible)
    {
        /*
        $topic->getId() will contain the FULL requested uri, so you can proceed based on that

        if ($topic->getId() == "acme/channel/shout")
        //shout something to all subs.
         */

        $pin1 = $event["pin1"];
        $pin2 = $event["pin2"];
        $state = $event["state"];

        if ($state == 0 || $state == 1) {
            $comando = "gpio mode " . $pin1 . " out";
            exec($comando);
            $comando = "gpio write " . $pin1 . " " . $state;
            exec($comando);
            $topic->broadcast("update");
        } else if ($state == 2) {
            $comando = "gpio mode " . $pin1 . " out";
            exec($comando);
            $comando = "gpio mode " . $pin2 . " out";
            exec($comando);
            $comando = "gpio write " . $pin1 . " 1";
            exec($comando);
            $comando = "gpio write " . $pin2 . " 0";
            exec($comando);
            $topic->broadcast("update");
        } else if ($state == 3) {
            $comando = "gpio mode " . $pin1 . " out";
            exec($comando);
            $comando = "gpio mode " . $pin2 . " out";
            exec($comando);
            $comando = "gpio write " . $pin1 . " 1";
            exec($comando);
            $comando = "gpio write " . $pin2 . " 1";
            exec($comando);
            $topic->broadcast("update");
        } else {
            $topic->broadcast("no_change");
        }
    }
    /**
     * Like RPC is will use to prefix the channel
     * @return string
     */
    public function getName()
    {
        return 'gpio.topic';
    }
}
