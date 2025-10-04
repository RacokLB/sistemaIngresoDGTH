<?php

namespace Models\Repositories;

use Error;
use Models\Entities\Pariente;
use PDO;
use PDOException;

class ParienteRepository {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function guardar(Pariente $pariente): ?Pariente {
        $sql = "INSERT INTO parientes (trabajadorId, cedula, nombre, apellido, fechaNacimiento, parentesco, genero discapacidad) VALUES (:trabajadorId,:cedula, :nombre, :apellido, :fechaNacimiento, :parentesco,
        :genero, :discapacidad)";
        try{
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':trabajadorId', $pariente->getTrabajadorId());
            $stmt->bindValue(':cedula', $pariente->getCedula());
            $stmt->bindValue(':nombre', $pariente->getNombre());
            $stmt->bindValue(':apellido', $pariente->getApellido());
            $stmt->bindValue(':fechaNacimiento', $pariente->getFechaNacimiento());
            $stmt->bindValue(':parentesco', $pariente->getParentesco());
            $stmt->bindValue(':discapacidad', $pariente->getDiscapacidad());
            // ...
            $stmt->execute();
            $pariente->id = $this->pdo->lastInsertId();
            return $pariente;
        }catch(PDOException $e){
            error_log("Error al guardar el pariente: " . $e->getMessage());
            return null;
        }
        
    }

    public function obtenerParienteId(int $id): ?Pariente {

        $sql ="SELECT * FROM parientes WHERE id = :id";
        try{
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch();
            if($row){
                return new Pariente(
                    id:$row['id'],
                    trabajadorId:$row['trabajadorId'],
                    cedula:$row['cedula'],
                    nombre:$row['nombre'],
                    apellido:$row['apellido'],
                    fechaNacimiento:$row['fechaNacimiento'],
                    parentesco:$row['parentesco'],
                    genero:$row['genero'],
                    discapacidad:$row['discapacidad']
                    
                );
            }
            return null;
        }catch(PDOException $e){
            error_log("Error al obtener al Pariente".$e->getMessage());
            return null;
        }
    }

    /**
     * Summary of obtenerParientes
     * @return array<Pariente> Un array de los datos de los parientes , o un array vacio en caso de no obtener ningun dato 
     */
    public function obtenerParientes(): array{
        $sql = "SELECT id,trabajadorId,cedula,nombre,apellido,parentesco,genero,discapacidad, TIMESTAMPDIFF(year,fechaNacimiento,NOW()) AS edad FROM parientes";
        try{
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $parientes = [];
            while($row = $stmt->fetch()){
                $parientes [] = new Pariente(
                    id:$row['id'],
                    trabajadorId:$row['trabajadorId'],
                    cedula:$row['cedula'],
                    nombre:$row['nombre'],
                    apellido:$row['apellido'],
                    fechaNacimiento:$row['edad'],
                    parentesco:$row['parentesco'],
                    genero:$row['genero'],
                    discapacidad:$row['discapacidad']

                );
            }
            $this->pdo->commit();
            return $parientes;
        }catch(PDOException $e){
            $this->pdo->rollBack();
            error_log('Error al obtener a los parientes: ' . $e->getMessage());
            return [];
        }
    }
    public function actualizar(Pariente $pariente): bool {
        $stmt = $this->pdo->prepare("UPDATE parientes SET trabajadorId = :trabajadorId,cedula = :cedula, nombre = :nombre, apellido = :apellido, fechaNacimiento = :fechaNacimiento, parentesco = :parentesco, genero = :genero, discapacidad = :discapacidad WHERE id = :id");
        $stmt->bindValue(':trabajadorId', $pariente->getTrabajadorId());
        $stmt->bindValue(':cedula', $pariente->getCedula());
        $stmt->bindValue(':nombre', $pariente->getNombre());
        $stmt->bindValue(':apellido', $pariente->getApellido());
        $stmt->bindValue(':fechaNacimiento', $pariente->getFechaNacimiento());
        $stmt->bindValue(':parentesco', $pariente->getParentesco());
        $stmt->bindValue(':discapacidad', $pariente->getDiscapacidad());
        return $stmt->execute();
    }

    public function eliminar(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM parientes WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT );
        return $stmt->execute();
    }
}

?>