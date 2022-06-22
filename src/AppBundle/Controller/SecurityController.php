<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{

    /**
     * @Route("/json", name="json")
     * @Method({"GET"})
     */
    public function jsonAction(Request $request)
    {
        $em = $this->get('doctrine')->getManager();
        $qb = $em->createQueryBuilder();
        $query = $qb->select('d')
            ->from('AppBundle:Dispositivos', 'd')
            ->where('d.tipo = 3')
            ->orderBy('d.nombre', 'ASC');
        $data = $query->getQuery()
            ->getArrayResult();
        return new JsonResponse($data);
    }

    /**
     * @Route("/scan", name="scan")
     * @Method({"GET"})
     */
    public function scanAction(Request $request)
    {
        return new RedirectResponse($this->generateUrl('login'));
    }

    public function send($data, $graduate, $user, $limit, $activar)
    {
        $sensores = array("Sensor de Humo", "Sensor de Movimiento #1", "Sensor de Movimiento #2");
        $message = (new \Swift_Message('Informacion Sensores'))
            ->setFrom('horariotps@gmail.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->renderView(
                    'AppBundle:Email:info.html.twig',
                    array(
                        'graduate' => $graduate,
                        'codigo' => $data[0],
                        'lugar' => $data[1],
                        'anio' => $data[2],
                        'fecha_evento' => $data[3],
                        'hora_evento' => $data[4],
                        'direccion' => $data[5],
                        'password' => $user->getPlainPassword(),
                        'fecha_limite' => $limit[0],
                        'hora_limite' => $limit[1],
                        'activar' => $activar)
                ),
                'text/html'
            )
            /*
         * If you also want to include a plaintext version of the message
        ->addPart(
        $this->renderView(
        'Emails/registration.txt.twig',
        array('name' => $name)
        ),
        'text/plain'
        )
         */
        ;

        $this->get('mailer')->send($message);

    }

    /**
     * @Route("/login/{message}", name="login", defaults={"message" = null}, requirements={"message" = "[a-z]{3,6}"} )
     * @Method({"GET"})
     */
    public function loginAction(Request $request, $message = null)
    {

        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->render('AppBundle:Security:active.html.twig',
                array(
                    'origen' => 'login',
                )
            );
        } else {
            if ($message == 'send' || $message == 'end' || $message == 'update' || $message == null) {

                $helper = $this->get('security.authentication_utils');

                return $this->render('AppBundle:Security:login.html.twig',
                    array(
                        'last_username' => $helper->getLastUsername(),
                        'error' => $helper->getLastAuthenticationError(),
                        'message' => $message,
                    )
                );

            } else {
                throw $this->createNotFoundException();
            }
        }
    }

    /**
     * @Route("/forget/{message}", name="forget", defaults={"message" = null}, requirements={"message" = "[a-z]{5,5}"} )
     * @Method({"GET"})
     */
    public function forgetAction($message = null)
    {

        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->render('AppBundle:Security:active.html.twig',
                array(
                    'origen' => 'forget',
                )
            );
        } else {
            if ($message == 'error' || $message == null) {
                return $this->render('AppBundle:Security:forget.html.twig',
                    array(
                        'message' => $message,
                    )
                );
            } else {
                throw $this->createNotFoundException();
            }
        }
    }

    /**
     * @Route("/reset/{error}/{token}", name="reset", defaults={"error" = null,"token" = null}, requirements={"token"=".+"})
     * @Method({"GET"})
     */
    public function resetAction($error = "index", $token = null)
    {

        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->render('AppBundle:Security:active.html.twig',
                array(
                    'origen' => 'reset',
                )
            );
        } else {
            $em = $this->get('doctrine')->getManager();
            $repository = $em->getRepository('AppBundle:Usuarios');
            $user = $repository->findOneByToken($token);
            if ($user == null) {
                return $this->render('AppBundle:Security:reset.html.twig', array('token' => '', 'error' => '', 'codigo' => '', 'tiempo' => ''));
            } else {
                if (new \DateTime() > $user->getFechaLimite()) {
                    return $this->render('AppBundle:Security:reset.html.twig', array('token' => $token, 'error' => 'end', 'codigo' => $user->getCodigo(), 'tiempo' => $user->getFechaLimite()));
                } else {

                    if ($error == 'index' || $error == 'different' || $error == 'error' || $error == null) {
                        return $this->render('AppBundle:Security:reset.html.twig', array('token' => $token, 'error' => $error, 'codigo' => $user->getCodigo(), 'tiempo' => ''));
                    } else {
                        throw $this->createNotFoundException();
                    }
                }
            }
        }
    }

    /**
     * @Route("/emailCheck", name="emailCheck")
     * @Method({"POST"})
     */
    public function emailCheckAction(Request $request)
    {
        $email = trim($request->request->get('email'));

        $em = $this->get('doctrine')->getManager();
        $repository = $em->getRepository('AppBundle:Usuarios');
        $user = $repository->findOneByEmail($email);

        if ($user == null) {
            return new RedirectResponse($this->generateUrl('forget', array('message' => 'error')));
        } else {
            $limite = new \DateTime();
            $limite->modify('+1 hour');
            $encoder = $this->get('security.password_encoder');
            $id = $user->getCodigo() . "-:-" . $limite->format('Y-m-d H:i');
            $token = $encoder->encodePassword($user, $id);

            $user->setFechaLimite($limite);
            $user->setToken($token);

            $em->persist($user);
            $em->flush();

            $message = (new \Swift_Message('Reestablecer Contraseña'))
                ->setFrom('horariotps@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'AppBundle:Email:reset.html.twig',
                        array(
                            'token' => $user->getToken(),
                            'usuario' => $user->getCodigo(),
                            'fecha_limite' => $user->getFechaLimite())
                    ),
                    'text/html'
                )
                /*
             * If you also want to include a plaintext version of the message
            ->addPart(
            $this->renderView(
            'Emails/registration.txt.twig',
            array('name' => $name)
            ),
            'text/plain'
            )
             */
            ;

            $this->get('mailer')->send($message);

            return new RedirectResponse($this->generateUrl('login', array('message' => 'send')));
        }
    }

/**
 * @Route("/password/reset", name="resetPassword")
 * @Method({"POST"})
 */
    public function resetPasswordAction(Request $request)
    {

        $encoder = $this->get('security.password_encoder');

        $token = trim($request->request->get('token'));
        $passN = trim($request->request->get('passN'));
        $passR = trim($request->request->get('passR'));

        if ($token == "" || strlen($passN) < 1 || strlen($passN) > 20 || strlen($passR) < 1 || strlen($passR) > 20) {
            return new RedirectResponse($this->generateUrl('reset', array('error' => 'error', 'token' => $token)));
        }

        if ($passN != $passR) {
            return new RedirectResponse($this->generateUrl('reset', array('error' => 'different', 'token' => $token)));
        }

        $em = $this->get('doctrine')->getManager();
        $repository = $em->getRepository('AppBundle:Usuarios');
        $usuario = $repository->findOneByToken($token);

        $nueva = $encoder->encodePassword($usuario, $passN);

        $this->change($usuario->getCodigo(), $nueva);

        return new RedirectResponse($this->generateUrl('login', array('message' => 'update')));

    }

    /**
     * @Route("/password/change", name="changePassword")
     * @Method({"POST"})
     * @Security("has_role('ROLE_ADMIN') or has_role('ROLE_USER')")
     */
    public function changePasswordAction(Request $request)
    {

        $encoder = $this->get('security.password_encoder');

        $passA = trim($request->request->get('passA'));
        $passN = trim($request->request->get('passN'));
        $passR = trim($request->request->get('passR'));

        if (strlen($passA) < 1 || strlen($passA) > 20 || strlen($passN) < 1 || strlen($passN) > 20 || strlen($passR) < 1 || strlen($passR) > 20) {
            if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
                return new RedirectResponse($this->generateUrl('adminPass', array('error' => 'error')));
            } else if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
                return new RedirectResponse($this->generateUrl('graduatePass', array('error' => 'error')));
            }
        }

        if ($passA == $passN) {
            if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
                return new RedirectResponse($this->generateUrl('adminPass', array('error' => 'equals')));
            } else if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
                return new RedirectResponse($this->generateUrl('graduatePass', array('error' => 'equals')));
            }
        }

        if ($passN != $passR) {
            if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
                return new RedirectResponse($this->generateUrl('adminPass', array('error' => 'different')));
            } else if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
                return new RedirectResponse($this->generateUrl('graduatePass', array('error' => 'different')));
            }
        }

        $usuario = $this->getUser();
        if ($encoder->isPasswordValid($usuario, $passA)) {
            $nueva = $encoder->encodePassword($usuario, $passN);

            $this->change($usuario->getUsername(), $nueva);

            $this->get('security.token_storage')->setToken(null);
            return new RedirectResponse($this->generateUrl('login', array('message' => 'update')));
        } else {

            return new RedirectResponse($this->generateUrl('passUpdate', array('error' => 'fail')));

        }
    }

    private function change($codigo, $password)
    {
        $em = $this->get('doctrine')->getManager();
        $repository = $em->getRepository('AppBundle:Usuarios');
        $user = $repository->find($codigo);
        $user->setPassword($password);
        $user->setToken("");
        $user->setFechaLimite(null);
        $em->persist($user);
        $em->flush();
    }

    /**
     * @Route("/login_check", name="security_login_check")
     * @Method({"POST"})
     * @Security("has_role('IS_AUTHENTICATED_ANONYMOUSLY')")
     */
    public function loginCheckAction(Request $request)
    {

    }

    /**
     * @Route("/logout", name="logout")
     * @Method({"GET"})
     * @Security("has_role('ROLE_ADMIN') or has_role('ROLE_USER')")
     */
    public function logoutAction(Request $request)
    {

    }
}
