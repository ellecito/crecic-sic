<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Giros extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->layout->current = 3;
		$this->layout->subCurrent = 6;
		$this->load->model("modelo_giro", "objGiro");
	}

	public function index(){
		#title
		$this->layout->title('Giros');
		
		#metas
		$this->layout->setMeta('title','Giros');
		$this->layout->setMeta('description','Giros');
        $this->layout->setMeta('keywords','Giros');
        
        $this->layout->js('assets/js/sistema/tabla.js');

		$contenido = [
			"giros" => $this->objGiro->listar()
		];

		$this->layout->view('index', $contenido);
	}

	public function agregar(){
		if($this->input->post()){
			#validacion
			$this->form_validation->set_rules('nombre', 'Nombre', 'required');
			
			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				$error = validation_errors();
				echo json_encode(array("result"=>false,"msg"=>$error));
				exit;
			}

			$data = [
				"gi_codigo" => $this->objGiro->getLastId(),
				"gi_nombre" => $this->input->post("nombre")
			];

			if($this->objGiro->insertar($data)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"<div>Error al guardar en la base de datos.</div>"));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Giro');
			
			#metas
			$this->layout->setMeta('title','Agregar Giro');
			$this->layout->setMeta('description','Agregar Giro');
			$this->layout->setMeta('keywords','Agregar Giro');

			#js
			$this->layout->js('assets/js/sistema/agregar.js');

			$this->layout->view('agregar');
		}
	}

	public function editar($codigo = false){
		if($this->input->post()){
			#validacion
			$this->form_validation->set_rules('nombre', 'Nombre', 'required');
			
			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				$error = validation_errors();
				echo json_encode(array("result"=>false,"msg"=>$error));
				exit;
			}

			$data = [
				"gi_nombre" => $this->input->post("nombre")
			];

			if($this->objGiro->actualizar($data, ["gi_codigo" => $this->input->post("codigo")])){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"<div>Error al actualizar la base de datos.</div>"));
				exit;
			}
		}else{
			if(!$codigo) redirect(base_url());
			#title
			$this->layout->title('Editar Giro');
			
			#metas
			$this->layout->setMeta('title','Editar Giro');
			$this->layout->setMeta('description','Editar Giro');
			$this->layout->setMeta('keywords','Editar Giro');

			#js
			$this->layout->js('assets/js/sistema/editar.js');
			
			$contenido = [
				"giro" => $this->objGiro->obtener_por_codigo($codigo)
			];

			$this->layout->view('editar', $contenido);
		}
	}
	
}