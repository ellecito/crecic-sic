<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Estudio_factibilidad extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->layout->current = 2;
		$this->load->model("modelo_estudio_factibilidad", "objFactibilidad");
		$this->load->model("tipo_curso/modelo_tipo_curso", "objTipoCurso");
		$this->load->model("sucursales/modelo_sucursal", "objSucursal");
		$this->load->model("cursos/modelo_curso", "objCurso");
		$this->load->model("empresas/modelo_empresa", "objEmpresa");
		$this->load->model("usuarios/modelo_usuario", "objUsuario");
	}

	public function index(){
		#title
		$this->layout->title('Estudio Factibilidad');
		
		#metas
		$this->layout->setMeta('title','Estudio Factibilidad');
		$this->layout->setMeta('description','Estudio Factibilidad');
        $this->layout->setMeta('keywords','Estudio Factibilidad');
        
        $this->layout->js('assets/js/sistema/tabla.js');

		$contenido = [
			"estudios_factibilidad" => $this->objFactibilidad->listar([
                "us_codigo" => $this->session->userdata("usuario")->codigo
			])
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
				"gi_codigo" => $this->objFactibilidad->getLastId(),
				"gi_nombre" => $this->input->post("nombre")
			];

			if($this->objFactibilidad->insertar($data)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"<div>Error al guardar en la base de datos.</div>"));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Estudio Factibilidad');
			
			#metas
			$this->layout->setMeta('title','Agregar Estudio Factibilidad');
			$this->layout->setMeta('description','Agregar Estudio Factibilidad');
			$this->layout->setMeta('keywords','Agregar Estudio Factibilidad');

			#js
			#BOOTSTRAP SELECT
			$this->layout->js('bower_components/bootstrap-select/dist/js/bootstrap-select.min.js');
			$this->layout->css('bower_components/bootstrap-select/dist/css/bootstrap-select.min.css');
			$this->layout->js('assets/js/sistema/select.js');

			#DATE
			$this->layout->css('vendor/components/jqueryui/themes/ui-lightness/jquery-ui.min.css');
            $this->layout->js('vendor/components/jqueryui/ui/jquery-1-7.js');
            $this->layout->js('vendor/components/jqueryui/ui/widgets/datepicker.js');
            $this->layout->js('vendor/components/jqueryui/ui/i18n/datepicker-es.js');
			$this->layout->js('assets/js/sistema/date.js');

			$this->layout->js('assets/js/sistema/agregar.js');

			$contenido = [
				"tipo_cursos" => $this->objTipoCurso->listar(),
				"sucursales" => $this->objSucursal->listar(),
				"cursos" => $this->objCurso->listar(
					"cu_fecha_vencimiento > '" . date("Y-m-d") . "'" 
				),
				"empresas" => $this->objEmpresa->listar(),
				"usuarios" => $this->objUsuario->listar() //Filtrar solo relatores y activos
			];

			$this->layout->view('agregar', $contenido);
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

			if($this->objFactibilidad->actualizar($data, ["gi_codigo" => $this->input->post("codigo")])){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"<div>Error al actualizar la base de datos.</div>"));
				exit;
			}
		}else{
			if(!$codigo) redirect(base_url());
			#title
			$this->layout->title('Editar Estudio Factibilidad');
			
			#metas
			$this->layout->setMeta('title','Editar Estudio Factibilidad');
			$this->layout->setMeta('description','Editar Estudio Factibilidad');
			$this->layout->setMeta('keywords','Editar Estudio Factibilidad');

			#js
			$this->layout->js('assets/js/sistema/editar.js');
			
			$contenido = [
				"giro" => $this->objFactibilidad->obtener_por_codigo($codigo)
			];

			$this->layout->view('editar', $contenido);
		}
	}
	
}