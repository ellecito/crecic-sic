<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Tipo_curso extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->layout->current = 3;
		$this->layout->subCurrent = 4;
		$this->load->model("modelo_tipo_curso", "objTipoCurso");
	}

	public function index(){
		#title
		$this->layout->title('Tipo Curso');
		
		#metas
		$this->layout->setMeta('title','Tipo Curso');
		$this->layout->setMeta('description','Tipo Curso');
        $this->layout->setMeta('keywords','Tipo Curso');
        
        $this->layout->js('assets/js/sistema/tabla.js');

		$contenido = [
			"tipo_cursos" => $this->objTipoCurso->listar()
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
				"tc_codigo" => $this->objTipoCurso->getLastId(),
				"tc_nombre" => $this->input->post("nombre")
			];

			if($this->objTipoCurso->insertar($data)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"<div>Error al guardar en la base de datos.</div>"));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Tipo Curso');
			
			#metas
			$this->layout->setMeta('title','Agregar Tipo Curso');
			$this->layout->setMeta('description','Agregar Tipo Curso');
			$this->layout->setMeta('keywords','Agregar Tipo Curso');

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
				"tc_nombre" => $this->input->post("nombre")
			];

			if($this->objTipoCurso->actualizar($data, ["tc_codigo" => $this->input->post("codigo")])){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"<div>Error al actualizar la base de datos.</div>"));
				exit;
			}
		}else{
			if(!$codigo) redirect(base_url());
			#title
			$this->layout->title('Editar Tipo Curso');
			
			#metas
			$this->layout->setMeta('title','Editar Tipo Curso');
			$this->layout->setMeta('description','Editar Tipo Curso');
			$this->layout->setMeta('keywords','Editar Tipo Curso');

			#js
			$this->layout->js('assets/js/sistema/editar.js');
			
			$contenido = [
				"tipo_curso" => $this->objTipoCurso->obtener_por_codigo($codigo)
			];

			$this->layout->view('editar', $contenido);
		}
	}
	
}