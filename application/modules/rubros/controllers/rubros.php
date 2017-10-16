<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Rubros extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		if($this->session->userdata("usuario")->perfil->codigo  != 1) redirect(base_url());
		$this->layout->current = 3;
		$this->layout->subCurrent = 11;
		$this->load->model("modelo_rubro", "objRubro");
	}

	public function index(){
		#title
		$this->layout->title('Rubros');
		
		#metas
		$this->layout->setMeta('title','Rubros');
		$this->layout->setMeta('description','Rubros');
        $this->layout->setMeta('keywords','Rubros');
        
        $this->layout->js('assets/js/sistema/tabla.js');

		$contenido = [
			"rubros" => $this->objRubro->listar()
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
				"ru_codigo" => $this->objRubro->getLastId(),
				"ru_nombre" => $this->input->post("nombre")
			];

			if($this->objRubro->insertar($data)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"<div>Error al guardar en la base de datos.</div>"));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Rubro');
			
			#metas
			$this->layout->setMeta('title','Agregar Rubro');
			$this->layout->setMeta('description','Agregar Rubro');
			$this->layout->setMeta('keywords','Agregar Rubro');

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
				"ru_nombre" => $this->input->post("nombre")
			];

			if($this->objRubro->actualizar($data, ["ru_codigo" => $this->input->post("codigo")])){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"<div>Error al actualizar la base de datos.</div>"));
				exit;
			}
		}else{
			if(!$codigo) redirect(base_url());
			#title
			$this->layout->title('Editar Rubro');
			
			#metas
			$this->layout->setMeta('title','Editar Rubro');
			$this->layout->setMeta('description','Editar Rubro');
			$this->layout->setMeta('keywords','Editar Rubro');

			#js
			$this->layout->js('assets/js/sistema/editar.js');
			
			$contenido = [
				"rubro" => $this->objRubro->obtener_por_codigo($codigo)
			];

			$this->layout->view('editar', $contenido);
		}
	}
	
}