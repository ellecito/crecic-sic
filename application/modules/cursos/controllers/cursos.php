<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Cursos extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->layout->current = 3;
		$this->layout->subCurrent = 3;
		$this->load->model("modelo_curso", "objCurso");
	}

	public function index(){
		#title
		$this->layout->title('Cursos');
		
		#metas
		$this->layout->setMeta('title','Cursos');
		$this->layout->setMeta('description','Cursos');
        $this->layout->setMeta('keywords','Cursos');
        
        $this->layout->js('assets/js/sistema/tabla.js');

		$contenido = [
			"cursos" => $this->objCurso->listar()
		];

		$this->layout->view('index', $contenido);
	}

	public function agregar(){
		if($this->input->post()){
			#validacion
            $this->form_validation->set_rules('sence', 'Código Sence', 'required');
            $this->form_validation->set_rules('nombre', 'Nombre', 'required');
            $this->form_validation->set_rules('horas', 'Horas', 'required');
            $this->form_validation->set_rules('alumnos', 'Alumnos', 'required');
            $this->form_validation->set_rules('fecha_emision', 'Fecha Emisión', 'required');
            $this->form_validation->set_rules('fecha_vencimiento', 'Fecha Vencimiento', 'required');
			
			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				$error = validation_errors();
				echo json_encode(array("result"=>false,"msg"=>$error));
				exit;
            }
            
            if($this->objCurso->obtener(["cu_sence" => $this->input->post("sence")])){
                echo json_encode(array("result"=>false,"msg"=>"<div>Código Sence ya esta registrado en el sistema.</div>"));
				exit;
            }

			$data = [
				"cu_codigo" => $this->objCurso->getLastId(),
                "cu_nombre" => $this->input->post("nombre"),
                "cu_sence" => $this->input->post("sence"),
                "cu_alumnos" => $this->input->post("alumnos"),
                "cu_horas" => $this->input->post("horas"),
                "cu_fecha_emision" => date("Y-m-d", strtotime(str_replace("/", "-", $this->input->post("fecha_emision")))),
                "cu_fecha_vencimiento" => date("Y-m-d", strtotime(str_replace("/", "-", $this->input->post("fecha_vencimiento"))))
			];

			if($this->objCurso->insertar($data)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"<div>Error al guardar en la base de datos.</div>"));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Curso');
			
			#metas
			$this->layout->setMeta('title','Agregar Curso');
			$this->layout->setMeta('description','Agregar Curso');
			$this->layout->setMeta('keywords','Agregar Curso');

            #js
            $this->layout->css('vendor/components/jqueryui/themes/ui-lightness/jquery-ui.min.css');
            $this->layout->js('vendor/components/jqueryui/ui/jquery-1-7.js');
            $this->layout->js('vendor/components/jqueryui/ui/widgets/datepicker.js');
            $this->layout->js('vendor/components/jqueryui/ui/i18n/datepicker-es.js');
            $this->layout->js('assets/js/sistema/date.js');
			$this->layout->js('assets/js/sistema/agregar.js');

			$this->layout->view('agregar');
		}
	}

	public function editar($codigo = false){
		if($this->input->post()){
			#validacion
			$this->form_validation->set_rules('sence', 'Código Sence', 'required');
            $this->form_validation->set_rules('nombre', 'Nombre', 'required');
            $this->form_validation->set_rules('horas', 'Horas', 'required');
            $this->form_validation->set_rules('alumnos', 'Alumnos', 'required');
            $this->form_validation->set_rules('fecha_emision', 'Fecha Emisión', 'required');
            $this->form_validation->set_rules('fecha_vencimiento', 'Fecha Vencimiento', 'required');
			
			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				$error = validation_errors();
				echo json_encode(array("result"=>false,"msg"=>$error));
				exit;
            }
            
            $curso = $this->objCurso->obtener_por_codigo($this->input->post("codigo"));

            if($curso->sence != $this->input->post("sence")){
                if($this->objCurso->obtener(["cu_sence" => $this->input->post("sence")])){
                    echo json_encode(array("result"=>false,"msg"=>"<div>Código Sence ya esta registrado en el sistema.</div>"));
                    exit;
                }
            }

			$data = [
                "cu_nombre" => $this->input->post("nombre"),
                "cu_sence" => $this->input->post("sence"),
                "cu_alumnos" => $this->input->post("alumnos"),
                "cu_horas" => $this->input->post("horas"),
                "cu_fecha_emision" => date("Y-m-d", strtotime(str_replace("/", "-", $this->input->post("fecha_emision")))),
                "cu_fecha_vencimiento" => date("Y-m-d", strtotime(str_replace("/", "-", $this->input->post("fecha_vencimiento"))))
			];

			if($this->objCurso->actualizar($data, ["cu_codigo" => $this->input->post("codigo")])){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"<div>Error al actualizar la base de datos.</div>"));
				exit;
			}
		}else{
			if(!$codigo) redirect(base_url());
			#title
			$this->layout->title('Editar Curso');
			
			#metas
			$this->layout->setMeta('title','Editar Curso');
			$this->layout->setMeta('description','Editar Curso');
			$this->layout->setMeta('keywords','Editar Curso');

            #js
            $this->layout->css('vendor/components/jqueryui/themes/ui-lightness/jquery-ui.min.css');
            $this->layout->js('vendor/components/jqueryui/ui/jquery-1-7.js');
            $this->layout->js('vendor/components/jqueryui/ui/widgets/datepicker.js');
            $this->layout->js('vendor/components/jqueryui/ui/i18n/datepicker-es.js');
            $this->layout->js('assets/js/sistema/date.js');
			$this->layout->js('assets/js/sistema/editar.js');
			
			$contenido = [
				"curso" => $this->objCurso->obtener_por_codigo($codigo)
			];

			$this->layout->view('editar', $contenido);
		}
	}
	
}