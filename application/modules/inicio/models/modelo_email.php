<?php

class Modelo_email extends CI_Model{
    private $from;
    private $empresa;

    function __construct(){
        $this->from = "no-reply@capcrecic.cl";
        $this->empresa = "Crecic Capacitaciones";
        parent::__construct();
    }

    public function notificar_ef($emails, $ef){
        $asunto = "Nuevo Estudio de Factibilidad";
        $cuerpo = "Se ha ingresado un nuevo <a href='" . base_url() . "estudio-factibilidad/editar/" . $ef . "/'>estudio de factibilidad</a>.";
        
        $this->email->from($this->from,utf8_decode($this->empresa));
        $this->email->to($emails);
        $this->email->subject(utf8_decode($asunto)." [".date('d/m/Y')." ".date('H:i:s')."]");
        $this->email->message(utf8_decode($cuerpo));
        $this->email->send();
    }
	
}
