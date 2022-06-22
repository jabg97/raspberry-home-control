<?php

namespace ControlBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     * @Method({"GET"})
     * @Template("ControlBundle:Default:index.html.twig")
     * @Security("has_role('ROLE_ADMIN') or has_role('ROLE_USER')")
     */
    public function indexAction()
    {
        $em = $this->get('doctrine')->getManager();
        $user = $this->getUser();
        if ($user->getRol() == "ROLE_ADMIN") {
            $repository = $em->getRepository('AppBundle:Dispositivos');
            $list = $repository->findBy(
                array('tipo' => 3),
                array('nombre' => 'ASC'));
        } else {
            $repository = $em->getRepository('AppBundle:User_Device');
            $rules = $repository->findByCodigo($user->getCodigo());
            $repository = $em->getRepository('AppBundle:Dispositivos');
            $list = array();

            foreach ($rules as $rule) {
                $device = $repository->findBy(
                    array('pin' => $rule->getPin()));
                if ($device[0]->getTipo() == 3) {
                    $list[] = $device[0];
                }
            }
        }

        $fin = count($list) - 1;

        $doble = array();
        for ($i = 0; $i <= $fin; $i++) {
            if (strpos($list[$i]->getLog(), "-:-") !== false) {
                $doble[$i] = 1;
            } else {
                $doble[$i] = 0;
            }
        }
        return array(
            'list' => $list,
            'size' => $fin,
            'doble' => $doble
        );
    }

    /**
     * @Route("/pass/{error}", name="passUpdate", defaults={"error" = null}, requirements={"error" = "[a-z]{4,9}"} )
     * @Method({"GET"})
     * @Template("ControlBundle:Security:pass.html.twig")
     * @Security("has_role('ROLE_ADMIN') or has_role('ROLE_USER')")
     */
    public function passAction(Request $request, $error = null)
    {
        if ($error == 'different' || $error == 'equals' || $error == 'error' || $error == 'fail' || $error == null) {
            return array('error' => $error, 'tiempo' => '');
        } else {
            throw $this->createNotFoundException();
        }
    }

    /**
     * @Route("/admin/devices/{message}", name="adminDevices", defaults={"message" = null}, requirements={"message" = "[a-z]{7,7}"} )
     * @Method({"GET"})
     * @Template("ControlBundle:Default:devices.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function devicesAction(Request $request, $message = null)
    {
        if ($message == 'success' || $message == null) {
            $em = $this->get('doctrine')->getManager();

            $qb = $em->createQueryBuilder();
            $qb->select('user')
                ->from('AppBundle:Usuarios', 'user')
                ->where('user.rol != :rol')
                ->setParameter('rol', 'ROLE_ADMIN');
            $list = $qb->getQuery()->getResult();

            $qb = $em->createQueryBuilder();
            $qb->select('device')
                ->from('AppBundle:Dispositivos', 'device')
                ->where('device.tipo = :tipo')
                ->setParameter('tipo', 2);
            $list2 = $qb->getQuery()->getResult();

            $paginator = $this->get('knp_paginator');
            $qb = $em->createQueryBuilder();
            $qb->select('device')
                ->from('AppBundle:Dispositivos', 'device');
            $query = $qb->getQuery();
            $devices = $qb->getQuery()->getResult();
            $users = array();
            $devices = array();
            $pagination = $paginator->paginate($query, $request->query->getInt('page', 1), 5);

            foreach ($pagination->getItems() as $key => &$device) {
                $users[$key] = $em->getRepository('AppBundle:User_Device')->findByPin($device->getPin());
                if ($users[$key] == null) {
                    $users[$key] = array();
                }

                $devices[$key] = array();

                if ($device->getTipo() == 2) {
                    $devices[$key] = $em->getRepository('AppBundle:In_Out')->findByPin($device->getPin());

                    if ($devices[$key] == null) {
                        $devices[$key] = array();
                    }
                }

            }

            return array(
                'pagination' => $pagination,
                'list' => $list,
                'list2' => $list2,
                'users' => $users,
                'devices' => $devices,
                'message' => $message);
        } else {
            throw $this->createNotFoundException();
        }
    }

    /**
     * @Route("/admin/users/{message}", name="adminUsers", defaults={"message" = null}, requirements={"message" = "[a-z]{5,7}"} )
     * @Method({"GET"})
     * @Template("ControlBundle:Default:users.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function usersAction(Request $request, $message = null)
    {
        if ($message == 'error' || $message == 'success' || $message == null) {
            $em = $this->get('doctrine')->getManager();
            $errors = array();
            if ($message == 'error') {
                $session = $this->get('session');
                $errors = $session->get('error_user');
            }
            $paginator = $this->get('knp_paginator');
            $qb = $em->createQueryBuilder();
            $qb->select('user')
                ->from('AppBundle:Usuarios', 'user')
                ->where('user.codigo != :username')
                ->setParameter('username', 'root');
            $query = $qb->getQuery();
            $pagination = $paginator->paginate($query, $request->query->getInt('page', 1), 5);
            return array(
                'pagination' => $pagination,
                'message' => $message,
                'errors' => $errors);
        } else {
            throw $this->createNotFoundException();
        }
    }

    private function backupIndex()
    {
        $em = $this->get('doctrine')->getManager();
        $user = $this->getUser();
        if ($user->getRol() == "ROLE_ADMIN") {
            $repository = $em->getRepository('AppBundle:Dispositivos');
            $list = $repository->findBy(
                array('tipo' => 3),
                array('nombre' => 'ASC'));
        } else {
            $repository = $em->getRepository('AppBundle:User_Device');
            $rules = $repository->findByCodigo($user->getCodigo());
            $repository = $em->getRepository('AppBundle:Dispositivos');
            $list = array();

            foreach ($rules as $rule) {
                $device = $repository->findBy(
                    array('pin' => $rule->getPin()));
                if ($device[0]->getTipo() == 3) {
                    $list[] = $device[0];
                }
            }
        }

        $fin = count($list) - 1;

        $estado = array();
        $doble = array();
        for ($i = 0; $i <= $fin; $i++) {
            if (strpos($list[$i]->getLog(), "-:-") !== false) {
                $doble[$i] = 1;

                $tmppin = explode("-:-", $list[$i]->getPin());
                $tmplog = explode("-:-", $list[$i]->getLog());
                $comando = "gpio mode " . $tmplog[0] . " out";
                exec($comando);
                $comando = "gpio read " . $tmplog[0];
                exec($comando, $actual);
                $tmp1 = $list[$i];
                //$tmp2 = new Dispositivos();
                $tmp2 = [];
                $pin2 = array($tmp1, $tmp2);
                if (@$actual[$i] == 0) {
                    $pin2[0]->setPin($tmppin[0]);
                    $pin2[0]->setLog($tmplog[0]);
                    $pin2[1]->setPin($tmppin[1]);
                    $pin2[1]->setLog($tmplog[1]);
                    $list[$i] = $pin2;
                    $actual[$i] = 0;
                } else {
                    $pin2[0]->setPin($tmppin[1]);
                    $pin2[0]->setLog($tmplog[1]);
                    $pin2[1]->setPin($tmppin[0]);
                    $pin2[1]->setLog($tmplog[0]);
                    $list[$i] = $pin2;
                    $actual[$i] == 1;
                }

            } else {
                $doble[$i] = 0;
                $comando = "gpio mode " . $list[$i]->getLog() . " out";
                //echo $comando.": ";
                exec($comando);
                $comando = "gpio read " . $list[$i]->getLog();
                exec($comando, $actual);
                //echo $comando."(".$actual[$i].")";

            }

            if (!isset($actual[$i])) {
                $actual[$i] = 0;
            }

        }

        if (!isset($actual)) {
            $actual = [];
        }

        return array(
            'list' => $list,
            'state' => $actual,
            'size' => $fin,
            'doble' => $doble,
        );
    }
}
