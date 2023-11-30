<?php
    class Usuario{
        public $id=0;
        public $nombre="";
        public $apellido1="";
        public $apellido2="";
        public $edad=0;
        public $fechaNac;//->format('Y-m-d');
        public $email="";
        public $genero="M";
        public $edoCivil=1;
        public $intereses=[];
        public $password="";

        public function __construct(){
            $this->fechaNac=new DateTime();
        }
    }
?>