<?php
namespace Models\Entities;



class Trabajador {
    //Atributos
    public $id;
    public $cedula;
    public $nacionalidad;
    public $rif;
    public $apellido;
    public $nombre;
    public $fechaNacimiento;
    public $estadoCivil;
    public $genero;
    public $discapacidad;
    public $numeroContacto;
    public $estatus;
    public $compania;
    public $fechaIngreso;
    public $tipoTrabajador;
    public $ubicacionGeneral;
    public $ubicacionEspecifica;
    public $ubicacion;
    public $gradoAcademico;
    public $codCargo;
    public $cargoDirector;
    public $edad;
    public $estado;
    public $ciudad;
    public $municipio;
    public $parroquia;
    public $direccion;
    public array $parientes = [];

    //apartado pariente
    public $idPariente;
    public $trabajadorId;
    public $cedulaPariente;
    public $nombrePariente;
    public $apellidoPariente;
    public $fechaNacimientoPariente;
    public $parentesco;
    public $generoPariente;
    public $discapacidadPariente;


    // Constructor
    public function __construct(
        $id = null,
        $cedula= null,
        $nacionalidad = null,
        $rif= null,
        $apellido= null,
        $nombre= null,
        $fechaNacimiento= null,
        $estadoCivil= null,
        $genero= null,
        $discapacidad= null,
        $numeroContacto= null,
        $estatus= null,
        $compania= null,
        $fechaIngreso= null,
        $tipoTrabajador= null,
        $ubicacionGeneral= null,
        $ubicacionEspecifica= null,
        $ubicacion = null,
        $gradoAcademico = null,
        $codCargo= null,
        $cargoDirector = null,
        $edad = null,
        $estado= null,
        $ciudad= null,
        $municipio= null,
        $parroquia= null,
        $direccion= null,
    
        $idPariente = null,
        $trabajadorId = null,
        $cedulaPariente = null,
        $nombrePariente = null,
        $apellidoPariente = null,
        $fechaNacimientoPariente = null,
        $parentesco = null,
        $generoPariente = null,
        $discapacidadPariente = null
    ) {
        $this->id = $id;
        $this->cedula = $cedula;
        $this->nacionalidad = $nacionalidad;
        $this->rif = $rif;
        $this->apellido = $apellido;
        $this->nombre = $nombre;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->estadoCivil = $estadoCivil;
        $this->genero = $genero;
        $this->discapacidad = $discapacidad;
        $this->numeroContacto = $numeroContacto;
        $this->estatus = $estatus;
        $this->compania = $compania;
        $this->fechaIngreso = $fechaIngreso;
        $this->tipoTrabajador = $tipoTrabajador;
        $this->ubicacionGeneral = $ubicacionGeneral;
        $this->ubicacionEspecifica = $ubicacionEspecifica;
        $this->ubicacion = $ubicacion;
        $this->gradoAcademico = $gradoAcademico;
        $this->edad = $edad;
        $this->estado = $estado;
        $this->ciudad = $ciudad;
        $this->municipio = $municipio;
        $this->parroquia = $parroquia;
        $this->direccion = $direccion;
        $this->codCargo = $codCargo;
        $this->cargoDirector = $cargoDirector;
        
        //Parientes
        $this->idPariente = $idPariente;
        $this->trabajadorId = $trabajadorId;
        $this->cedulaPariente = $cedulaPariente;
        $this->nombrePariente = $nombrePariente;
        $this->apellidoPariente = $apellidoPariente;
        $this->fechaNacimientoPariente = $fechaNacimientoPariente;
        $this->parentesco = $parentesco;
        $this->generoPariente = $generoPariente;
        $this->discapacidadPariente = $discapacidadPariente;

    }


    // Métodos Getters (para acceder a las propiedades)
    public function getId() { return $this->id; }
    public function setId(?int $id): void { $this->id = $id; }
    public function getNacionalidad() { return $this->nacionalidad; }
    public function setNacionalidad(?string $nacionalidad): void { $this->nacionalidad = $nacionalidad; }
    public function getCedula() { return $this->cedula; }
    public function setCedula(?int $cedula): void { $this->cedula = $cedula; }
    public function getNombre() { return $this->nombre; }
    public function setNombre(?string $nombre): void { $this->nombre = $nombre; }
    public function getApellido() { return $this->apellido; }
    public function setApellido(?string $apellido): void { $this->apellido = $apellido; }
    public function getEstadoCivil() { return $this->estadoCivil; }
    public function setEstadoCivil(?string $estadoCivil): void {$this->estadoCivil = $estadoCivil;}
    public function getFechaNacimiento() { return $this->fechaNacimiento; }
    public function setFechaNacimiento(?string $fechaNacimiento): void { $this->fechaNacimiento = $fechaNacimiento;}
    public function getEdad(){return $this->edad;}
    public function getGenero() { return $this->genero; }
    public function setGenero(?string $genero): void { $this->genero = $genero; }
    public function getDiscapacidad(){return $this->discapacidad;}
    public function setDiscapacidad(?string $discapacidad){$this->discapacidad = $discapacidad;}
    public function getNumeroContacto() { return $this->numeroContacto; }
    public function setNumeroContacto(?string $numeroContacto): void {$this->numeroContacto = $numeroContacto;}
    public function getEstatus(){return $this->estatus;}
    public function setEstatus(?string $estatus): void{$this->estatus = $estatus;}
    public function getCompania(){return $this->compania;}
    public function setCompania(?int $compania): void{$this->compania=$compania;}
    public function getRif() { return $this->rif; }
    public function setRif(?string $rif): void { $this->rif = $rif; }
    public function getFechaIngreso() { return $this->fechaIngreso; }
    public function setFechaIngreso(?string $fechaIngreso): void { $this->fechaIngreso = $fechaIngreso; }
    public function getEstado() { return $this->estado; }
    public function setEstado(?int $estado): void { $this->estado = $estado; }
    public function getCiudad() { return $this->ciudad; }
    public function setCiudad(?int $ciudad): void { $this->ciudad = $ciudad; }
    public function getMunicipio() { return $this->municipio; }
    public function setMunicipio(?int $municipio): void {$this->municipio = $municipio;}
    public function getParroquia() { return $this->parroquia; }
    public function setParroquia(?int $parroquia): void {$this->parroquia = $parroquia;}
    public function getDireccion() { return $this->direccion; }
    public function setDireccion(?string $direccion): void{$this->direccion = $direccion;}
    public function getTipoTrabajador() { return $this->tipoTrabajador; }
    public function setTipoTrabajador(?string $tipoTrabajador): void { $this->tipoTrabajador = $tipoTrabajador; }
    public function getUbicacionGeneral() { return $this->ubicacionGeneral; }
    public function setUbicacionGeneral(?int $ubicacionGeneral): void {$this->ubicacionGeneral = $ubicacionGeneral;}
    public function getUbicacionEspecifica() { return $this->ubicacionEspecifica; }
    public function setUbicacionEspecifica(?int $ubicacionEspecifica): void {$this->ubicacionEspecifica = $ubicacionEspecifica;}
    public function getUbicacion(){return $this->ubicacion;}
    public function setUbicacion(?int $ubicacion): void {$this->ubicacion = $ubicacion;}
    public function getGradoAcademico() { return $this->gradoAcademico;}
    public function setGradoAcademico(?int $gradoAcademico): void {$this->gradoAcademico = $gradoAcademico;}
    public function getCodCargo() { return $this->codCargo; }
    public function setCodCargo(?int $codCargo): void { $this->codCargo = $codCargo; }
    public function getCargoDirector(){return $this->cargoDirector;}
    public function setCargoDirector(?int $cargoDirector): void {$this->cargoDirector = $cargoDirector;}
    

    // Getters para la clase Pariente
    public function getIdPariente() { return $this->idPariente; }
    public function setIdPariente(?int $idPariente): void{$this->idPariente = $idPariente;}
    public function getTrabajadorId() { return $this->trabajadorId; }
    public function setTrabajadorId(?int $trabajadorId): void {$this->trabajadorId = $trabajadorId;}
    public function getCedulaPariente() { return $this->cedulaPariente; }
    public function setCedulaPariente(?string $cedulaPariente): void{$this->cedulaPariente = $cedulaPariente;}
    public function getNombrePariente() { return $this->nombrePariente; }
    public function setNombrePariente(?string $nombrePariente): void {$this->nombrePariente = $nombrePariente;}
    public function getApellidoPariente() { return $this->apellidoPariente; }
    public function setApellidoPariente(?string $apellidoPariente): void{$this->apellidoPariente = $apellidoPariente;}
    public function getFechaNacimientoPariente() { return $this->fechaNacimientoPariente; }
    public function setFechaNacimientoPariente(?string $fechaNacimientoPariente){$this->fechaNacimientoPariente = $fechaNacimientoPariente;}
    public function getParentesco() { return $this->parentesco; }
    public function setParentesco(?string $parentesco): void{$this->parentesco = $parentesco;}
    public function getGeneroPariente(){return $this->generoPariente;}
    public function setGeneroPariente(?string $generoPariente): void{$this->generoPariente = $generoPariente;}
    public function getDiscapacidadPariente() { return $this->discapacidadPariente; }
    public function setDiscapacidadPariente(?string $discapacidadPariente): void {$this->discapacidadPariente = $discapacidadPariente;}



}



?>