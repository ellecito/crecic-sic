<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Empresas extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->layout->current = 3;
		$this->layout->subCurrent = 5;
		$this->load->model("modelo_empresa", "objEmpresa");
		$this->load->model("giros/modelo_giro", "objGiro");
		$this->load->model("regiones/modelo_region", "objRegion");
		$this->load->model("comunas/modelo_comuna", "objComuna");
	}

	public function index(){
		#title
		$this->layout->title('Empresas');
		
		#metas
		$this->layout->setMeta('title','Empresas');
		$this->layout->setMeta('description','Empresas');
		$this->layout->setMeta('keywords','Empresas');

		$this->layout->js('assets/js/sistema/tabla.js');

		$contenido = [
			"empresas" => $this->objEmpresa->listar()
		];

		$this->layout->view('index', $contenido);
	}

	public function agregar(){
		if($this->input->post()){
			#validacion
			$this->form_validation->set_rules('rut', 'RUT', 'required');
			$this->form_validation->set_rules('razon_social', 'Razón Social', 'required');
			$this->form_validation->set_rules('direccion', 'Dirección', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required');
			$this->form_validation->set_rules('giro', 'Giro', 'required');
			$this->form_validation->set_rules('comuna', 'Comuna', 'required');
			
			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				$error = validation_errors();
				echo json_encode(array("result"=>false,"msg"=>$error));
				exit;
			}

			if($this->objEmpresa->obtener(["em_rut" => $this->input->post("rut")])){
				echo json_encode(array("result"=>false,"msg"=>"<div>Este RUT ya esta registrado.</div>"));
				exit;
			}

			$data = [
				"em_codigo" => $this->objEmpresa->getLastId(),
				"em_rut" => $this->input->post("rut"),
				"em_razon_social" => $this->input->post("razon_social"),
				"em_direccion" => $this->input->post("direccion"),
				"em_email" => $this->input->post("email"),
				"gi_codigo" => $this->input->post("giro"),
				"co_codigo" => $this->input->post("comuna")
			];

			if($this->objEmpresa->insertar($data)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"<div>Error al guardar en la base de datos.</div>"));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Empresa');
			
			#metas
			$this->layout->setMeta('title','Agregar Empresa');
			$this->layout->setMeta('description','Agregar Empresa');
			$this->layout->setMeta('keywords','Agregar Empresa');

			#js
			#BOOTSTRAP SELECT
			$this->layout->js('bower_components/bootstrap-select/dist/js/bootstrap-select.min.js');
			$this->layout->css('bower_components/bootstrap-select/dist/css/bootstrap-select.min.css');

			#rut
			$this->layout->js('assets/js/validador-rut/jquery.Rut.js');
			$this->layout->js('assets/js/sistema/rut.js');

			$this->layout->js('assets/js/sistema/select.js');
			$this->layout->js('assets/js/sistema/region.js');
			$this->layout->js('assets/js/sistema/agregar.js');

			$contenido = [
				"giros" => $this->objGiro->listar(),
				"regiones" => $this->objRegion->listar(),
				"comunas" => $this->objComuna->listar()
			];

			$this->layout->view('agregar', $contenido);
		}
	}

	public function editar($codigo = false){
		if($this->input->post()){
			#validacion
			$this->form_validation->set_rules('rut', 'RUT', 'required');
			$this->form_validation->set_rules('razon_social', 'Razón Social', 'required');
			$this->form_validation->set_rules('direccion', 'Dirección', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required');
			$this->form_validation->set_rules('giro', 'Giro', 'required');
			$this->form_validation->set_rules('comuna', 'Comuna', 'required');
			
			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				$error = validation_errors();
				echo json_encode(array("result"=>false,"msg"=>$error));
				exit;
			}

			$data = [
				"em_rut" => $this->input->post("rut"),
				"em_razon_social" => $this->input->post("razon_social"),
				"em_direccion" => $this->input->post("direccion"),
				"em_email" => $this->input->post("email"),
				"gi_codigo" => $this->input->post("giro"),
				"co_codigo" => $this->input->post("comuna")
			];

			if($this->objEmpresa->actualizar($data, ["em_codigo" => $this->input->post("codigo")])){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"<div>Error al actualizar la base de datos.</div>"));
				exit;
			}
		}else{
			if(!$codigo) redirect(base_url());
			#title
			$this->layout->title('Editar Empresa');
			
			#metas
			$this->layout->setMeta('title','Editar Empresa');
			$this->layout->setMeta('description','Editar Empresa');
			$this->layout->setMeta('keywords','Editar Empresa');

			#js
			#BOOTSTRAP SELECT
			$this->layout->js('bower_components/bootstrap-select/dist/js/bootstrap-select.min.js');
			$this->layout->css('bower_components/bootstrap-select/dist/css/bootstrap-select.min.css');

			#rut
			$this->layout->js('assets/js/validador-rut/jquery.Rut.js');
			$this->layout->js('assets/js/sistema/rut.js');

			$this->layout->js('assets/js/sistema/select.js');
			$this->layout->js('assets/js/sistema/region.js');
			$this->layout->js('assets/js/sistema/editar.js');

			$empresa = $this->objEmpresa->obtener_por_codigo($codigo);
			$contenido = [
				"giros" => $this->objGiro->listar(),
				"comunas" => $this->objComuna->listar(["re_codigo" => $empresa->comuna->region->codigo]),
				"regiones" => $this->objRegion->listar(),
				"empresa" => $empresa
			];

			$this->layout->view('editar', $contenido);
		}
	}

	public function comunas(){
		if($this->input->post()){
			$html = '<option disabled selected>Seleccione</option>';
			$comunas = $this->objComuna->listar(["re_codigo" => $this->input->post("region")]);
			foreach($comunas as $comuna){
				$html.= '<option value="' . $comuna->codigo . '">' . $comuna->nombre . '</option>';
			}
			echo json_encode(["result" => true, "html" => $html]);
			exit;
		}else{
			redirect(base_url());
		}
	}
	
}