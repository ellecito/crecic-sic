<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Tipo_manual extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->layout->current = 3;
		$this->layout->subCurrent = 10;
		$this->load->model("modelo_tipo_manual", "objTipoManual");
	}

	public function index(){
		#title
		$this->layout->title('Tipo Manual');
		
		#metas
		$this->layout->setMeta('title','Tipo Manual');
		$this->layout->setMeta('description','Tipo Manual');
        $this->layout->setMeta('keywords','Tipo Manual');
        
        $this->layout->js('assets/js/sistema/tabla.js');

		$contenido = [
			"tipo_manuales" => $this->objTipoManual->listar()
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
				"tm_codigo" => $this->objTipoManual->getLastId(),
				"tm_nombre" => $this->input->post("nombre")
			];

			if($this->objTipoManual->insertar($data)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"<div>Error al guardar en la base de datos.</div>"));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Tipo Manual');
			
			#metas
			$this->layout->setMeta('title','Agregar Tipo Manual');
			$this->layout->setMeta('description','Agregar Tipo Manual');
			$this->layout->setMeta('keywords','Agregar Tipo Manual');

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
				"tm_nombre" => $this->input->post("nombre")
			];

			if($this->objTipoManual->actualizar($data, ["tm_codigo" => $this->input->post("codigo")])){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"<div>Error al actualizar la base de datos.</div>"));
				exit;
			}
		}else{
			if(!$codigo) redirect(base_url());
			#title
			$this->layout->title('Editar Tipo Manual');
			
			#metas
			$this->layout->setMeta('title','Editar Tipo Manual');
			$this->layout->setMeta('description','Editar Tipo Manual');
			$this->layout->setMeta('keywords','Editar Tipo Manual');

			#js
			$this->layout->js('assets/js/sistema/editar.js');
			
			$contenido = [
				"tipo_manual" => $this->objTipoManual->obtener_por_codigo($codigo)
			];

			$this->layout->view('editar', $contenido);
		}
	}
	
}