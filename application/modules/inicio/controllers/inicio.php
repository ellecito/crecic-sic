<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Inicio extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if($this->session->userdata("usuario")) redirect(base_url() . "estudio-factibilidad/");
		$this->load->model("usuarios/modelo_usuario", "objUsuario");
	}

	public function index(){
		#TITLE
		$this->layout->title('Login');
		
		#METAS
		$this->layout->setMeta('title','Login');
		$this->layout->setMeta('description','Login');
		$this->layout->setMeta('keywords','Login');

		#CSS
		$this->layout->css('assets/css/sb-admin.css');
		$this->layout->css('assets/css/hoja-estilos.css');

		#JS
		$this->layout->js('assets/js/validador-rut/jquery.Rut.js');
		$this->layout->js('assets/js/sistema/login.js');

		$contenido["home"] = true;

		$this->layout->view('inicio', $contenido);
	}

	public function login(){
		
		if($this->input->post()){
			#validacion
			$this->form_validation->set_rules('rut', 'RUT', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			
			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');
			
			if(!$this->form_validation->run()){
				$error = validation_errors();
				echo json_encode(array("result"=>false,"msg"=>$error));
			}
			else
			{
				try{
					$where = array(
						"us_rut" => $this->input->post('rut'),
						"us_password" => md5($this->input->post('password')),
						"us_estado" => "t"
					);
					if($usuario = $this->objUsuario->obtener($where)){
						$this->session->set_userdata('usuario',$usuario);
						echo json_encode(array("result"=>true, "url" => "estudio-factibilidad/"));
					}else{
						echo json_encode(array("result"=>false,"msg"=>"Los datos ingresados no son validos."));
					}
				}
				catch(Exception $e){
					echo json_encode(array("result"=>false,"msg"=>$e->getMessage()));
				}
			}
		}else{
			redirect('/');
		}
	}
	
	public function logout(){
		$this->session->sess_destroy();
		redirect('/');
	}	
}