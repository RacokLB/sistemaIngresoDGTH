<?php

namespace Models\Entities;


class Pariente {
    // Atributos de la clase Pariente
    public $id;
    private $trabajadorId;    
    public $cedula;
    public $nombre;
    public $apellido;
    public $fechaNacimiento;
    public $parentesco;
    public $genero;
    public $discapacidad;

    public function __construct(
    $id = null, 
    $trabajadorId = null, 
    $cedula = null, 
    $nombre = null, 
    $apellido = null, 
    $fechaNacimiento = null,
    $parentesco = null,
    $genero = null, 
    $discapacidad = null
    ) {
        $this->id = $id;
        $this->trabajadorId = $trabajadorId;
        $this->cedula = $cedula;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->parentesco = $parentesco;
        $this->genero = $genero;
        $this->discapacidad = $discapacidad;
    }

    public function ObtenerTrabajadorId(): ?int {
        return $this->trabajadorId;
    }

    public function setTrabajadorId(Trabajador $trabajadorId): void {
        $this->trabajadorId = $trabajadorId;
    }


    // Getters para la clase Pariente
    public function getId() { return $this->id; }
    public function setId(int $id){$this->id = $id;}
    public function getTrabajadorId() { return $this->trabajadorId; }
    public function setTrabajadotId(int $trabajadorId) {$this->trabajadorId = $trabajadorId;}
    public function getCedula() { return $this->cedula; }
    public function setCedula(string $cedula){$this->cedula = $cedula;}
    public function getNombre() { return $this->nombre; }
    public function setNombre(string $nombre) {$this->nombre = $nombre;}
    public function getApellido() { return $this->apellido; }
    public function setApellido(string $apellido){$this->apellido = $apellido;}
    public function getFechaNacimiento() { return $this->fechaNacimiento; }
    public function setFechaNacimiento(string $fechaNacimiento){$this->fechaNacimiento = $fechaNacimiento;}
    public function getParentesco() { return $this->parentesco; }
    public function setParentesco(string $parentesco){$this->parentesco = $parentesco;}
    public function getGenero(){return $this->genero;}
    public function setGenero(string $genero){$this->genero = $genero;}
    public function getDiscapacidad() { return $this->discapacidad; }
    public function setDiscapacidad(string $discapacidad){$this->discapacidad = $discapacidad;}

}
    
?>