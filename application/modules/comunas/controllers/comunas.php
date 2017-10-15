<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Comunas extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		if($this->session->userdata("usuario")->perfil->codigo  != 1) redirect(base_url());
		$this->layout->current = 3;
		$this->layout->subCurrent = 8;
        $this->load->model("modelo_comuna", "objComuna");
        $this->load->model("regiones/modelo_region", "objRegion");
	}

	public function index(){
		#title
		$this->layout->title('Comunas');
		
		#metas
		$this->layout->setMeta('title','Comunas');
		$this->layout->setMeta('description','Comunas');
        $this->layout->setMeta('keywords','Comunas');
        
        $this->layout->js('assets/js/sistema/tabla.js');

		$contenido = [
			"comunas" => $this->objComuna->listar()
		];

		$this->layout->view('index', $contenido);
	}

	public function agregar(){
		if($this->input->post()){
			#validacion
            $this->form_validation->set_rules('nombre', 'Nombre', 'required');
            $this->form_validation->set_rules('region', 'Región', 'required');
			
			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				$error = validation_errors();
				echo json_encode(array("result"=>false,"msg"=>$error));
				exit;
			}

			$data = [
				"co_codigo" => $this->objComuna->getLastId(),
                "co_nombre" => $this->input->post("nombre"),
                "re_codigo" => $this->input->post("region")
			];

			if($this->objComuna->insertar($data)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"<div>Error al guardar en la base de datos.</div>"));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Comuna');
			
			#metas
			$this->layout->setMeta('title','Agregar Comuna');
			$this->layout->setMeta('description','Agregar Comuna');
			$this->layout->setMeta('keywords','Agregar Comuna');

			#js
			$this->layout->js('bower_components/bootstrap-select/dist/js/bootstrap-select.min.js');
			$this->layout->css('bower_components/bootstrap-select/dist/css/bootstrap-select.min.css');
			$this->layout->js('assets/js/sistema/select.js');
			$this->layout->js('assets/js/sistema/agregar.js');
            
            $contenido = [
                "regiones" => $this->objRegion->listar()
            ];

			$this->layout->view('agregar', $contenido);
		}
	}

	public function editar($codigo = false){
		if($this->input->post()){
			#validacion
            $this->form_validation->set_rules('nombre', 'Nombre', 'required');
            $this->form_validation->set_rules('region', 'Región', 'required');
			
			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				$error = validation_errors();
				echo json_encode(array("result"=>false,"msg"=>$error));
				exit;
			}

			$data = [
                "co_nombre" => $this->input->post("nombre"),
                "re_codigo" => $this->input->post("region")
			];

			if($this->objComuna->actualizar($data, ["co_codigo" => $this->input->post("codigo")])){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"<div>Error al actualizar la base de datos.</div>"));
				exit;
			}
		}else{
			if(!$codigo) redirect(base_url());
			#title
			$this->layout->title('Editar Comuna');
			
			#metas
			$this->layout->setMeta('title','Editar Comuna');
			$this->layout->setMeta('description','Editar Comuna');
			$this->layout->setMeta('keywords','Editar Comuna');

			#js
			$this->layout->js('bower_components/bootstrap-select/dist/js/bootstrap-select.min.js');
			$this->layout->css('bower_components/bootstrap-select/dist/css/bootstrap-select.min.css');
			$this->layout->js('assets/js/sistema/select.js');
			$this->layout->js('assets/js/sistema/editar.js');
			
			$contenido = [
                "comuna" => $this->objComuna->obtener_por_codigo($codigo),
                "regiones" => $this->objRegion->listar()
			];

			$this->layout->view('editar', $contenido);
		}
	}
	
}