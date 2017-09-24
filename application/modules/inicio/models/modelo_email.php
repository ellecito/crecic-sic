<?php

class Modelo_email extends CI_Model
{

    function __construct(){
    
        parent::__construct();
    }

    public function recuperar($new_contrasena){
    
        $asunto = "Nuevo Recuperar contraseña";
        $cuerpo = "Se ha ingresado un nuevo formulario de recuperar contraseña. Por favor, cambiarla lo antes posible en el modulo <a href='http://example.com/'>perfil</a>.<br /><br />
        Datos: <br /><br />
		<b>Email</b>: " . $this->input->post("email") . "
		<br /><b>Contraseña nueva</b>: " . $new_contrasena;
        
        $this->email->from("no-reply@empresa.cl",utf8_decode("Empresa"));
        $this->email->to($this->input->post("email"));
        $this->email->subject(utf8_decode($asunto)." [".date('d/m/Y')." ".date('H:i:s')."]");
        $this->email->message(utf8_decode($cuerpo));
        $this->email->send();
    }
	
}
