<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Dispositivos
 *
 * @ORM\Table(name="dispositivos")
 * @ORM\Entity
 * @UniqueEntity(fields={"pin"}, message="El pin '{{ value }}' ya esta en uso")
 * @UniqueEntity(fields={"nombre"}, message="El nombre '{{ value }}'' ya esta en uso")
 * @UniqueEntity(fields={"log"}, message="El pin logico '{{ value }}'' ya esta en uso")
 */
class Dispositivos
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
 *      maxMessage = "El pin '{{ value }}' debe tener maximoo {{ limit }} caracteres"
 * )

 */
    private $pin;

    /**
     * @var string

     * @ORM\Column(name="nombre", type="string", length=50, nullable=false , unique=true)

     * @Assert\NotBlank(
     *     message="El nombre no puede estar vacio."
     * )

     * @Assert\NotNull(
     *     message="El nombre no puede estar vacio."
     * )

     * @Assert\Length(
     *      min = 1,
     *      max = 50,
     *      minMessage = "El nombre '{{ value }}' debe tener minimo {{ limit }} caracteres",
     *      maxMessage = "El nombre '{{ value }}' debe tener maximoo {{ limit }} caracteres"
     * )

     */
    private $nombre;

/**
 * @var string

 * @ORM\Column(name="log", type="string", length=7, nullable=false , unique=true)

 * @Assert\NotBlank(
 *     message="El pin logico no puede estar vacio."
 * )

 * @Assert\NotNull(
 *     message="El pin logico no puede estar vacio."
 * )

 * @Assert\Length(
 *      min = 1,
 *      max = 7,
 *      minMessage = "El pin logico '{{ value }}' debe tener minimo {{ limit }} caracteres",
 *      maxMessage = "El pin logico '{{ value }}' debe tener maximoo {{ limit }} caracteres"
 * )

 */
    private $log;

    /**
     * @var integer
     *
     * @ORM\Column(name="tipo", type="smallint", options={"unsigned"=true}, nullable=false)
     * @Assert\NotBlank(
     *     message="El tipo no puede estar vacio."
     * )

     * @Assert\NotNull(
     *     message="El tipo no puede estar vacio."
     * )

     * @Assert\Length(
     *      min = 1,
     *      max = 1,
     *      exactMessage = "El tipo '{{ value }}' debe tener exactamente {{ limit }} digitos",
     * )

     * @Assert\Range(
     *      min = 1,
     *      max = 3,
     *      minMessage = "El tipo debe ser minimo {{ limit }} ",
     *      maxMessage = "El tipo debe ser maximo {{ limit }} "
     * )

     * @Assert\Regex(
     *     pattern="/^[0-9]+$/",
     *     match=true,
     *     message="El tipo '{{ value }}' solo debe tener numeros"
     * )

     */
    private $tipo;

    /**
     * @var integer
     *
     * @ORM\Column(name="`signal`", type="smallint", options={"unsigned"=true}, nullable=false)
     * @Assert\NotBlank(
     *     message="La señal no puede estar vacio."
     * )

     * @Assert\NotNull(
     *     message="La señal no puede estar vacio."
     * )

     * @Assert\Length(
     *      min = 1,
     *      max = 1,
     *      exactMessage = "La señal '{{ value }}' debe tener exactamente {{ limit }} digitos",
     * )

     * @Assert\Range(
     *      min = 0,
     *      max = 4,
     *      minMessage = "La señal debe ser minimo {{ limit }} ",
     *      maxMessage = "La señal debe ser maximo {{ limit }} "
     * )

     * @Assert\Regex(
     *     pattern="/^[0-9]+$/",
     *     match=true,
     *     message="La señal '{{ value }}' solo debe tener numeros"
     * )

     */
    private $signal;

    public function create($pin, $nombre, $log, $tipo, $signal = 1)
    {
        $this->pin = $pin;
        $this->nombre = $nombre;
        $this->log = $log;
        $this->tipo = $tipo;
        $this->signal = $signal;
    }

    /**
     * Set pin
     *
     * @param string $pin
     *
     * @return Dispositivos
     */
    public function setPin($pin)
    {
        $this->pin = $pin;

        return $this;
    }

    /**
     * Get pin
     *
     * @return string
     */
    public function getPin()
    {
        return $this->pin;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Dispositivos
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set log
     *
     * @param string $log
     *
     * @return Dispositivos
     */
    public function setLog($log)
    {
        $this->log = $log;

        return $this;
    }

    /**
     * Get log
     *
     * @return string
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * Set tipo
     *
     * @param integer $tipo
     *
     * @return Dispositivos
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

/**
 * Get tipo
 *
 * @return integer
 */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set signal
     *
     * @param integer $signal
     *
     * @return Dispositivos
     */
    public function setSignal($signal)
    {
        $this->signal = $signal;

        return $this;
    }

/**
 * Get signal
 *
 * @return integer
 */
    public function getSignal()
    {
        return $this->signal;
    }

}
