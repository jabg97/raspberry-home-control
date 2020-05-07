<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User_Device
 *
 * @ORM\Table(name="user_device")
 * @ORM\Entity
 * @UniqueEntity(fields={"pin","codigo"}, message="La relacion '{{ value }}' ya esta en uso")
 */
class User_Device
{

/**
     * @var string

     * @ORM\Id
     * @ORM\Column(name="pin", type="string", length=7, nullable=false)

* @Assert\NotBlank(
     *     message="El pin no puede estar vacio."
     * )

     * @Assert\NotNull(
     *     message="El pin no puede estar vacio."
     * )

* @Assert\Length(
     *      min = 1,
     *      max = 7,
     *      minMessage = "El pin '{{ value }}' debe tener minimo {{ limit }} caracteres",
     *      maxMessage = "El pin '{{ value }}' debe tener maximo {{ limit }} caracteres"
     * )

     */
    private $pin;


    /**
     * @ORM\Id;
     * @Assert\NotBlank(
     *     message="El codigo de usuario no puede estar vacio."
     * )
     * @Assert\NotNull(
     *     message="El codigo de usuario no puede estar vacio."
     * )
    * @Assert\Length(
     *      min = 1,
     *      max = 20,
     *      minMessage = "El usuario debe tener minimo {{ limit }} caracteres",
     *      maxMessage = "El usuario debe tener maximo {{ limit }} caracteres"
     * )
     * @Assert\Regex(
     *     pattern="/^[a-z0-9]+$/",
     *     match=true,
     *     message="El usuario tiene un formato invalido"
     * )
     * @ORM\Column(type="string", length=20, nullable=false)
     */
    protected $codigo;
   
    public function create ($pin,$codigo)
    {
$this->pin = $pin;
$this->codigo = $codigo;
    }

    
    public function setPin($pin)
    {
        $this->pin = $pin;

        return $this;
    }


    public function getPin()
    {
        return $this->pin;
    }

    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    public function getCodigo()
    {
        return $this->codigo;
    }


}
