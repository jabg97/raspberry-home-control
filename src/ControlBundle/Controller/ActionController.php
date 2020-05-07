<?php

namespace ControlBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use AppBundle\Entity\Usuarios;
use AppBundle\Entity\User_Device;
use AppBundle\Entity\In_Out;


class ActionController extends Controller
{
/**
    * @Route("/admin/insertUser", name="insertUser")
     * @Method({"POST"})
      * @Security("has_role('ROLE_ADMIN')")
     */
    public function insertUserAction(Request $request)
    {

$codigo =  mb_strtolower(trim($request->request->get('codigo')), "UTF-8");
   $email = trim($request->request->get('email'));
   $password = trim($request->request->get('password'));
   $rol = trim($request->request->get('rol'));

   $validator = $this->get('validator');
   $user = new Usuarios();
   $user->create($codigo,$email,$password,$rol);

   $errors = $validator->validate($user);

   if (count($errors) > 0) {
       $session = $this->get('session');
$session->set('error_user',$errors);
        return new RedirectResponse($this->generateUrl('adminUsers', array('message' => 'error')));
    }else{

            $encoder = $this->get('security.password_encoder');
            $user->setPassword($encoder->encodePassword($this->getUser(), $password));
            $em = $this->get('doctrine')->getManager();
            $em->persist($user);
            $em->flush();
            return new RedirectResponse($this->generateUrl('adminUsers', array('message' => 'success'))); 
        
    }
}


/**
    * @Route("/admin/updateUser", name="updateUser")
     * @Method({"POST"})
      * @Security("has_role('ROLE_ADMIN')")
     */
    public function updateUserAction(Request $request)
    {
      if ($request->isXMLHttpRequest()){  
         $codigo =  mb_strtolower(trim($request->request->get('codigo')), "UTF-8");
     $action = trim($request->request->get('action'));

     $em = $this->get('doctrine')->getManager();
     $user = $em->getRepository('AppBundle:Usuarios')->find($codigo);

     if ($action == "edit"){
        $email = trim($request->request->get('email'));
        $rol = trim($request->request->get('rol'));

        if($email == '' || $rol == ''){
        return new JsonResponse(array("fail","Los datos del usuario \"".$codigo."\" estan incompletos"));             
        }


            if(!$this->validarEmail($email)){
                return new JsonResponse(array("fail","El email \"".$email."\" tiene un formato inválido"));             
            }
        
        if($this->existeEmail($codigo,$email,$em)){
            return new JsonResponse(array("fail","El email \"".$email."\" ya esta en uso")); 
            }
            
            $user->setEmail($email);
            $user->setRol($rol);
            $em->persist($user);
            $em->flush();
        
         return new JsonResponse(array("success","El usuario \"".$codigo."\" ha sido modificado")); 
     }else if ($action == "delete"){
$em->remove($user);
         $em->flush();
return new JsonResponse(array("success","El usuario  \"".$codigo."\" ha sido eliminado"));
     }
       return new JsonResponse(array("fail","Peticion indefinida")); 
    }
   throw $this->createNotFoundException();   
}


/**
    * @Route("/gpio/{pin1}/{pin2}/{state}", name="gpioUpdate", defaults={"pin1" = null,"pin2" = null,"state" = null}, requirements={"pin1" = "[0-9]{1,2}","pin2" = "-?[0-9]{1,2}","state" = "[0-9]{1,1}"} )
     * @Method({"GET"})
      * @Security("has_role('ROLE_ADMIN') or has_role('ROLE_USER')")
     */
    public function gpioUpdateAction(Request $request,$pin1 = null,$pin2 = null,$state = null)
    {
        if($state == 0 || $state == 1){
		$comando = "gpio mode ".$pin1." out";
	    exec($comando);
        $comando = "gpio write ".$pin1." ".$state;
	   	exec($comando);
	}else if($state == 2){
		$comando = "gpio mode ".$pin1." out";
	    exec($comando);
	    $comando = "gpio mode ".$pin2." out";
	    exec($comando);
        $comando = "gpio write ".$pin1." 1";
		exec($comando);
		$comando = "gpio write ".$pin2." 0";
		exec($comando);
	}else if($state == 3){
		$comando = "gpio mode ".$pin1." out";
	    exec($comando);
	    $comando = "gpio mode ".$pin2." out";
	    exec($comando);
        $comando = "gpio write ".$pin1." 1";
		exec($comando);
		$comando = "gpio write ".$pin2." 1";
		exec($comando);    
	}
	        return new RedirectResponse($this->generateUrl('home'));

}

/**
    * @Route("/admin/updateDevice", name="updateDevice")
     * @Method({"POST"})
      * @Security("has_role('ROLE_ADMIN')")
     */
    public function updateDeviceAction(Request $request)
    {
      if ($request->isXMLHttpRequest()){  
         $pin =  trim($request->request->get('pin'));
     $action = trim($request->request->get('action'));

     $em = $this->get('doctrine')->getManager();
     $device = $em->getRepository('AppBundle:Dispositivos')->find($pin);

     if ($action == "edit"){
        $nombre = trim($request->request->get('nombre'));
        $log = trim($request->request->get('log'));
        $tipo = trim($request->request->get('tipo'));

        if($nombre == '' || $log == '' || $tipo == ''){
        return new JsonResponse(array("fail","Los datos del dispositivo \"".$nombre."\" estan incompletos"));             
        }

            
            $device->setNombre($nombre);
            $device->setLog($log);
            $device->setTipo($tipo);
            $em->persist($device);
            $em->flush();
        
         return new JsonResponse(array("success","El dispositivo \"".$nombre."\" ha sido modificado")); 
     }else if ($action == "delete"){
$em->remove($device);
         $em->flush();
return new JsonResponse(array("success","El dispositivo  \"".$nombre."\" ha sido eliminado"));
     }
       return new JsonResponse(array("fail","Peticion indefinida")); 
    }
   throw $this->createNotFoundException();   
}

/**
    * @Route("/admin/assignUser", name="assignUser")
     * @Method({"POST"})
      * @Security("has_role('ROLE_ADMIN')")
     */
    public function assignUserAction(Request $request)
    {


   $pin = trim($request->request->get('pin'));
   $users = $request->request->get('users');
   $em = $this->get('doctrine')->getManager();

   $qb = $em->createQueryBuilder();
   $qb->delete('AppBundle:User_Device','assign')
   ->where('assign.pin = :pin')
   ->setParameter('pin',$pin)
   ->getQuery()->execute();
   $em->flush();

   if($users != null){
   foreach ($users as &$user) {
    $asignar = new User_Device();
    $asignar->create($pin,$user);
    $em->persist($asignar);
    $em->flush();
}
}
            
            
            return new RedirectResponse($this->generateUrl('adminDevices', array('message' => 'success'))); 
        

}

/**
    * @Route("/admin/assignDevice", name="assignDevice")
     * @Method({"POST"})
      * @Security("has_role('ROLE_ADMIN')")
     */
    public function assignDeviceAction(Request $request)
    {


   $in = trim($request->request->get('in'));
   $outs = $request->request->get('outs');
   $em = $this->get('doctrine')->getManager();

   $qb = $em->createQueryBuilder();
   $qb->delete('AppBundle:In_Out','assign')
   ->where('assign.pin = :in')
   ->setParameter('in',$in)
   ->getQuery()->execute();
   $em->flush();

   if($outs != null){
   foreach ($outs as &$out) {
    $asignar = new In_Out();
    $asignar->create($in,$out);
    $em->persist($asignar);
    $em->flush();
}
}
            
            
            return new RedirectResponse($this->generateUrl('adminDevices', array('message' => 'success'))); 
        

}

public function existeEmail($codigo,$email,$em)
{
    $qb = $em->createQueryBuilder();
    $qb->select('COUNT(user.codigo)');
    $qb->from('AppBundle:Usuarios','user');
    $qb->where('user.email = :email');
    $qb->andWhere('user.codigo != :codigo');
    $qb->setParameters(array('email' => $email, 'codigo' => $codigo));
    $query = $qb->getQuery();
    $users = $query->getSingleScalarResult();
return $users > 0;
}

public function validarEmail($email){
    return filter_var($email, FILTER_VALIDATE_EMAIL) 
    && preg_match('/@.+\./', $email);
}

}
