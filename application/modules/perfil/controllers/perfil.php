<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Perfil extends CI_Controller {
	
	function __construct(){
		parent::__construct();
        if(!$this->session->userdata("usuario")) redirect(base_url());
        $this->load->model("usuarios/modelo_usuario", "objUsuario");
		$this->load->model("regiones/modelo_region", "objRegion");
        $this->load->model("comunas/modelo_comuna", "objComuna");
        $this->load->model("sucursales/modelo_sucursal", "objSucursal");
	}

	public function index(){
		if($this->input->post()){
			#validacion
			$this->form_validation->set_rules('rut', 'RUT', 'required');
			$this->form_validation->set_rules('nombres', 'Nombres', 'required');
            $this->form_validation->set_rules('apellido_paterno', 'Apellido Paterno', 'required');
            $this->form_validation->set_rules('apellido_materno', 'Apellido Materno', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('comuna', 'Comuna', 'required');
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
                "su_codigo" => $this->input->post("sucursal"),
				"co_codigo" => $this->input->post("comuna")
			];

			if($this->objUsuario->actualizar($data, ["us_codigo" => $this->session->userdata("usuario")->codigo])){
                $this->session->set_userdata('usuario',$this->objUsuario->obtener_por_codigo($this->session->userdata("usuario")->codigo));
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"<div>Error al actualizar la base de datos.</div>"));
				exit;
			}
		}else{
			#title
			$this->layout->title('Editar Perfil');
			
			#metas
			$this->layout->setMeta('title','Editar Perfil');
			$this->layout->setMeta('description','Editar Perfil');
			$this->layout->setMeta('keywords','Editar Perfil');

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
			
			$contenido = [
				"comunas" => $this->objComuna->listar(["re_codigo" => $this->session->userdata("usuario")->comuna->region->codigo]),
				"regiones" => $this->objRegion->listar(),
                "sucursales" => $this->objSucursal->listar()
			];

			$this->layout->view('index', $contenido);
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