<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Usuarios extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		if($this->session->userdata("usuario")->perfil->codigo  != 1) redirect(base_url());
		$this->layout->current = 3;
		$this->layout->subCurrent = 1;
		$this->load->model("modelo_usuario", "objUsuario");
		$this->load->model("regiones/modelo_region", "objRegion");
        $this->load->model("comunas/modelo_comuna", "objComuna");
        $this->load->model("perfiles/modelo_perfil", "objPerfil");
        $this->load->model("sucursales/modelo_sucursal", "objSucursal");
	}

	public function index(){
		#title
		$this->layout->title('Usuarios');
		
		#metas
		$this->layout->setMeta('title','Usuarios');
		$this->layout->setMeta('description','Usuarios');
        $this->layout->setMeta('keywords','Usuarios');
        
        $this->layout->js('assets/js/sistema/index_usuario.js');
        $this->layout->js('assets/js/sistema/tabla.js');

		$contenido = [
			"usuarios" => $this->objUsuario->listar()
		];

		$this->layout->view('index', $contenido);
	}

	public function estados(){
		try{
			list($codigo,$estado) = explode('-',$this->input->post('codigo'));
			$this->objUsuario->actualizar(array("us_estado"=>$estado),array("us_codigo"=>$codigo));
			echo json_encode(array("result"=>true));
		}
		catch(Exception $e){
			echo json_encode(array("result"=>false,"msg"=>"Ha ocurrido un error inesperado. Por favor, inténtelo nuevamente."));
		}
	}

	public function agregar(){
		if($this->input->post()){
			#validacion
			$this->form_validation->set_rules('rut', 'RUT', 'required');
			$this->form_validation->set_rules('nombres', 'Nombres', 'required');
            $this->form_validation->set_rules('apellido_paterno', 'Apellido Paterno', 'required');
            $this->form_validation->set_rules('apellido_materno', 'Apellido Materno', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('comuna', 'Comuna', 'required');
            $this->form_validation->set_rules('perfil', 'Perfil', 'required');
            $this->form_validation->set_rules('sucursal', 'Sucursal', 'required');
			
			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				$error = validation_errors();
				echo json_encode(array("result"=>false,"msg"=>$error));
				exit;
			}

			if($this->objUsuario->obtener(["us_rut" => $this->input->post("rut")])){
				echo json_encode(array("result"=>false,"msg"=>"<div>Este RUT ya esta registrado.</div>"));
				exit;
			}

			$data = [
				"us_codigo" => $this->objUsuario->getLastId(),
				"us_rut" => $this->input->post("rut"),
				"us_nombres" => $this->input->post("nombres"),
                "us_apellido_paterno" => $this->input->post("apellido_paterno"),
                "us_apellido_materno" => $this->input->post("apellido_materno"),
                "us_email" => $this->input->post("email"),
                "us_password" => md5($this->input->post("password")),
                "pe_codigo" => $this->input->post("perfil"),
                "su_codigo" => $this->input->post("sucursal"),
				"co_codigo" => $this->input->post("comuna")
			];

			if($this->objUsuario->insertar($data)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"<div>Error al guardar en la base de datos.</div>"));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Usuario');
			
			#metas
			$this->layout->setMeta('title','Agregar Usuario');
			$this->layout->setMeta('description','Agregar Usuario');
			$this->layout->setMeta('keywords','Agregar Usuario');

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
				"regiones" => $this->objRegion->listar(),
                "comunas" => $this->objComuna->listar(),
                "sucursales" => $this->objSucursal->listar(),
                "perfiles" => $this->objPerfil->listar()
			];

			$this->layout->view('agregar', $contenido);
		}
	}

	public function editar($codigo = false){
		if($this->input->post()){
			#validacion
			$this->form_validation->set_rules('rut', 'RUT', 'required');
			$this->form_validation->set_rules('nombres', 'Nombres', 'required');
            $this->form_validation->set_rules('apellido_paterno', 'Apellido Paterno', 'required');
            $this->form_validation->set_rules('apellido_materno', 'Apellido Materno', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('comuna', 'Comuna', 'required');
            $this->form_validation->set_rules('perfil', 'Perfil', 'required');
            $this->form_validation->set_rules('sucursal', 'Sucursal', 'required');
			
			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				$error = validation_errors();
				echo json_encode(array("result"=>false,"msg"=>$error));
				exit;
			}

			$data = [
				"us_rut" => $this->input->post("rut"),
				"us_nombres" => $this->input->post("nombres"),
                "us_apellido_paterno" => $this->input->post("apellido_paterno"),
                "us_apellido_materno" => $this->input->post("apellido_materno"),
                "us_email" => $this->input->post("email"),
                "pe_codigo" => $this->input->post("perfil"),
                "su_codigo" => $this->input->post("sucursal"),
				"co_codigo" => $this->input->post("comuna")
			];

			if($this->objUsuario->actualizar($data, ["us_codigo" => $this->input->post("codigo")])){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"<div>Error al actualizar la base de datos.</div>"));
				exit;
			}
		}else{
			if(!$codigo) redirect(base_url());
			#title
			$this->layout->title('Editar Usuario');
			
			#metas
			$this->layout->setMeta('title','Editar Usuario');
			$this->layout->setMeta('description','Editar Usuario');
			$this->layout->setMeta('keywords','Editar Usuario');

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
			
			$usuario = $this->objUsuario->obtener_por_codigo($codigo);
			$contenido = [
				"comunas" => $this->objComuna->listar(["re_codigo" => $usuario->comuna->region->codigo]),
				"regiones" => $this->objRegion->listar(),
                "sucursales" => $this->objSucursal->listar(),
                "perfiles" => $this->objPerfil->listar(),
                "usuario" => $usuario
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