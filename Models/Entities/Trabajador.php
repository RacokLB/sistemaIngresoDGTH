<?php
namespace Models\Entities;


class Trabajador {
    //Atributos
    public $id;
    public $nacionalidad;
    public $cedula;
    public $nombre;
    public $apellido;
    public $estadoCivil;
    public $rif;
    public $tipoTrabajador;
    public $numeroContacto;
    public $fechaNacimiento;
    public $fechaIngreso;
    public $genero;
    private $parientes = []; // Array para almacenar objetos Pariente
    public $estado;
    public $ciudad;
    public $municipio;
    public $parroquia;
    public $direccion;
    public $direccionGeneral;
    public $direccionEspecifica;
    public $codCargo;
    public $pensionSobreviviente;
    public $familiarCne;
    public $padresComunCne;

    private $con;

    // Constructor
    public function __construct(
        $id = null,
        $nacionalidad = null,
        $cedula= null,
        $nombre= null,
        $apellido= null,
        $estadoCivil= null,
        $rif= null,
        $tipoTrabajador= null,
        $codCargo= null,
        $numeroContacto= null,
        $fechaNacimiento= null,
        $fechaIngreso= null,
        $genero= null,
        $estado= null,
        $ciudad= null,
        $municipio= null,
        $parroquia= null,
        $direccion= null,
        $direccionGeneral= null,
        $direccionEspecifica= null,
        $pensionSobreviviente= null,
        $familiarCne= null,
        $padresComunCne= null
    ) {
        $this->id = $id;
        $this->nacionalidad = $nacionalidad;
        $this->cedula = $cedula;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->estadoCivil = $estadoCivil;
        $this->rif = $rif;
        $this->tipoTrabajador = $tipoTrabajador;
        $this->codCargo = $codCargo;
        $this->numeroContacto = $numeroContacto;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->fechaIngreso = $fechaIngreso;
        $this->genero = $genero;
        $this->estado = $estado;
        $this->ciudad = $ciudad;
        $this->municipio = $municipio;
        $this->parroquia = $parroquia;
        $this->direccion = $direccion;
        $this->direccionGeneral = $direccionGeneral;
        $this->direccionEspecifica = $direccionEspecifica;
        $this->pensionSobreviviente = $pensionSobreviviente;
        $this->familiarCne = $familiarCne;
        $this->padresComunCne = $padresComunCne;
    }
    //Metodos para obtener a los parientes 
    public function agregarPariente(Pariente $pariente): void{
        $this->parientes[] = $pariente;
    }

    public function obtenerParientes(): array{
        return $this->parientes;
    }

    // Métodos Getters (para acceder a las propiedades)
    public function getId() { return $this->id; }
    public function setId(int $id) { $this->id = $id; }
    public function getNacionalidad() { return $this->nacionalidad; }
    public function setNacionalidad(string $nacionalidad) { $this->nacionalidad = $nacionalidad; }
    public function getCedula() { return $this->cedula; }
    public function setCedula(string $cedula) { $this->cedula = $cedula; }
    public function getNombre() { return $this->nombre; }
    public function setNombre(string $nombre) { $this->nombre = $nombre; }
    public function getApellido() { return $this->apellido; }
    public function setApellido(string $apellido) { $this->apellido = $apellido; }
    public function getEstadoCivil() { return $this->estadoCivil; }
    public function setEstadoCivil(string $estadoCivil) {$this->estadoCivil = $estadoCivil;}
    public function getRif() { return $this->rif; }
    public function setRif(string $rif) { $this->rif = $rif; }
    public function getTipoTrabajador() { return $this->tipoTrabajador; }
    public function setTipoTrabajador(string $tipoTrabajador) { $this->tipoTrabajador = $tipoTrabajador; }
    public function getCodCargo() { return $this->codCargo; }
    public function setCodCargo(int $codCargo) { $this->codCargo = $codCargo; }
    public function getNumeroContacto() { return $this->numeroContacto; }
    public function setNumeroContacto(int $numeroContacto) {$this->numeroContacto = $numeroContacto;}
    public function getFechaNacimiento() { return $this->fechaNacimiento; }
    public function setFechaNacimiento(string $fechaNacimiento) { $this->fechaNacimiento = $fechaNacimiento; }
    public function getFechaIngreso() { return $this->fechaIngreso; }
    public function setFechaIngreso(string $fechaIngreso) { $this->fechaIngreso = $fechaIngreso; }
    public function getGenero() { return $this->genero; }
    public function setGenero(string $genero) { $this->genero = $genero; }
    public function getParientes() { return $this->parientes; }
    public function setParientes(array $parientes) { $this->parientes = $parientes; }
    public function getEstado() { return $this->estado; }
    public function setEstado(int $estado) { $this->estado = $estado; }
    public function getCiudad() { return $this->ciudad; }
    public function setCiudad(int $ciudad) { $this->ciudad = $ciudad; }
    public function getMunicipio() { return $this->municipio; }
    public function setMunicipio(int $municipio) {$this->municipio = $municipio;}
    public function getParroquia() { return $this->parroquia; }
    public function setParroquia(int $parroquia) {$this->parroquia = $parroquia;}
    public function getDireccion() { return $this->direccion; }
    public function setDireccion(string $direccion){$this->direccion = $direccion;}
    public function getDireccionGeneral() { return $this->direccionGeneral; }
    public function setDireccionGeneral(int $direccionGeneral) {$this->direccionGeneral = $direccionGeneral;}
    public function getDireccionEspecifica() { return $this->direccionEspecifica; }
    public function setDireccionEspecifica(int $direccionEspecifica) {$this->direccionEspecifica = $direccionEspecifica;}
    public function getPensionSobreviviente() { return $this->pensionSobreviviente; }
    public function setPensionSobreviviente(string $pensionSobreviviente){$this->pensionSobreviviente = $pensionSobreviviente;}
    public function getFamiliarCne() { return $this->familiarCne; }
    public function setFamiliarCne(string $familiarCne) {$this->familiarCne = $familiarCne;}
    public function getPadresComunCne() { return $this->padresComunCne; }
    public function setPadresComunCne(string $padresComunCne) {$this->padresComunCne = $padresComunCne;}


        
}



?>