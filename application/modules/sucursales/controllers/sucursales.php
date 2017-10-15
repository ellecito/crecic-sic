<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Sucursales extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		if($this->session->userdata("usuario")->perfil->codigo  != 1) redirect(base_url());
		$this->layout->current = 3;
		$this->layout->subCurrent = 9;
		$this->load->model("modelo_sucursal", "objSucursal");
	}

	public function index(){
		#title
		$this->layout->title('Sucursales');
		
		#metas
		$this->layout->setMeta('title','Sucursales');
		$this->layout->setMeta('description','Sucursales');
        $this->layout->setMeta('keywords','Sucursales');
        
        $this->layout->js('assets/js/sistema/tabla.js');

		$contenido = [
			"sucursales" => $this->objSucursal->listar()
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
				"su_codigo" => $this->objSucursal->getLastId(),
				"su_nombre" => $this->input->post("nombre")
			];

			if($this->objSucursal->insertar($data)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"<div>Error al guardar en la base de datos.</div>"));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Sucursal');
			
			#metas
			$this->layout->setMeta('title','Agregar Sucursal');
			$this->layout->setMeta('description','Agregar Sucursal');
			$this->layout->setMeta('keywords','Agregar Sucursal');

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
				"su_nombre" => $this->input->post("nombre")
			];

			if($this->objSucursal->actualizar($data, ["su_codigo" => $this->input->post("codigo")])){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"<div>Error al actualizar la base de datos.</div>"));
				exit;
			}
		}else{
			if(!$codigo) redirect(base_url());
			#title
			$this->layout->title('Editar Sucursal');
			
			#metas
			$this->layout->setMeta('title','Editar Sucursal');
			$this->layout->setMeta('description','Editar Sucursal');
			$this->layout->setMeta('keywords','Editar Sucursal');

			#js
			$this->layout->js('assets/js/sistema/editar.js');
			
			$contenido = [
				"sucursal" => $this->objSucursal->obtener_por_codigo($codigo)
			];

			$this->layout->view('editar', $contenido);
		}
	}
	
}