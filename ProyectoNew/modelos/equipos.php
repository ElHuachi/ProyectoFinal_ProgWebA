<?php
class equipos{
    public $IdE=0;
    public $NombreEquipo="";
    public $Estudiante1="";
    public $Estudiante2="";
    public $Estudiante3="";
    public $Coach="";
    public $Institucion="";
    public $FotoEquipo="";
    public $Aprobado= 0;

    public function getIdE() {
        return $this->IdE;
    }

    public function getNombreEquipo() {
        return $this->NombreEquipo;
    }

    public function getEstudiante1() {
        return $this->Estudiante1;
    }
    public function getEstudiante2() {
        return $this->Estudiante2;
    }
    public function getEstudiante3() {
        return $this->Estudiante3;
    }

    public function getCoach() {
        return $this->Coach;
    }

    public function getNombreI() {
        return $this->Institucion;
    }

    public function getFotoEquipo() {
        return $this->FotoEquipo;
    }
    public function getAprobado() {
        return $this->Aprobado;
    }
}
?>
