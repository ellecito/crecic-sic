<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Regiones extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->layout->current = 3;
		$this->layout->subCurrent = 7;
		$this->load->model("modelo_region", "objRegion");
	}

	public function index(){
		#title
		$this->layout->title('Regiones');
		
		#metas
		$this->layout->setMeta('title','Regiones');
		$this->layout->setMeta('description','Regiones');
        $this->layout->setMeta('keywords','Regiones');
        
        $this->layout->js('assets/js/sistema/tabla.js');

		$contenido = [
			"regiones" => $this->objRegion->listar()
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
				"re_codigo" => $this->objRegion->getLastId(),
				"re_nombre" => $this->input->post("nombre")
			];

			if($this->objRegion->insertar($data)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"<div>Error al guardar en la base de datos.</div>"));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Región');
			
			#metas
			$this->layout->setMeta('title','Agregar Región');
			$this->layout->setMeta('description','Agregar Región');
			$this->layout->setMeta('keywords','Agregar Región');

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
				"re_nombre" => $this->input->post("nombre")
			];

			if($this->objRegion->actualizar($data, ["re_codigo" => $this->input->post("codigo")])){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"<div>Error al actualizar la base de datos.</div>"));
				exit;
			}
		}else{
			if(!$codigo) redirect(base_url());
			#title
			$this->layout->title('Editar Región');
			
			#metas
			$this->layout->setMeta('title','Editar Región');
			$this->layout->setMeta('description','Editar Región');
			$this->layout->setMeta('keywords','Editar Región');

			#js
			$this->layout->js('assets/js/sistema/editar.js');
			
			$contenido = [
				"region" => $this->objRegion->obtener_por_codigo($codigo)
			];

			$this->layout->view('editar', $contenido);
		}
	}
	
}