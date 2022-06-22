<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * In_Out
 *
 * @ORM\Table(name="in_out")
 * @ORM\Entity
 * @UniqueEntity(fields={"pin","pout"}, message="La relacion '{{ value }}' ya esta en uso")
 */
class In_Out
{

/**
 * @var string

 * @ORM\Id
 * @ORM\Column(name="pin", type="string", length=7, nullable=false)

 * @Assert\NotBlank(
 *     message="El pin de entrada no puede estar vacio."
 * )

 * @Assert\NotNull(
 *     message="El pin de entrada no puede estar vacio."
 * )

 * @Assert\Length(
 *      min = 1,
 *      max = 7,
 *      minMessage = "El pin de entrada '{{ value }}' debe tener minimo {{ limit }} caracteres",
 *      maxMessage = "El pin de entrada '{{ value }}' debe tener maximo {{ limit }} caracteres"
 * )

 */
    private $pin;

/**
 * @var string

 * @ORM\Id
 * @ORM\Column(name="pout", type="string", length=7, nullable=false)

 * @Assert\NotBlank(
 *     message="El pin de salida no puede estar vacio."
 * )

 * @Assert\NotNull(
 *     message="El pin de salida no puede estar vacio."
 * )

 * @Assert\Length(
 *      min = 1,
 *      max = 7,
 *      minMessage = "El pin de salida '{{ value }}' debe tener minimo {{ limit }} caracteres",
 *      maxMessage = "El pin de salida '{{ value }}' debe tener maximo {{ limit }} caracteres"
 * )

 */
    private $pout;

    public function create($pin, $pout)
    {
        $this->pin = $pin;
        $this->pout = $pout;
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

    public function setPout($pout)
    {
        $this->pout = $pout;
    }

    public function getPout()
    {
        return $this->pout;
    }

}
