<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Estudio_factibilidad extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->layout->current = 2;
		$this->load->model("modelo_estudio_factibilidad", "objFactibilidad");
		$this->load->model("modelo_cronograma", "objCronograma");
		$this->load->model("modelo_requerimiento_tecnico", "objRequerimientoTecnico");
		$this->load->model("modelo_requerimiento_academico", "objRequerimientoAcademico");
		$this->load->model("modelo_requerimiento_adquisicion", "objRequerimientoAdquisicion");
		$this->load->model("modelo_coctel", "objCoctel");
		$this->load->model("modelo_relatores", "objRelator");
		$this->load->model("tipo_curso/modelo_tipo_curso", "objTipoCurso");
		$this->load->model("tipo_manual/modelo_tipo_manual", "objTipoManual");
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
        $this->layout->js('assets/js/sistema/index_ef.js');

		$contenido = [
			"estudios_factibilidad" => $this->objFactibilidad->listar([
                "us_codigo" => $this->session->userdata("usuario")->codigo
			])
		];

		$this->layout->view('index', $contenido);
	}

	public function estados(){
		try{
			list($codigo,$estado) = explode('-',$this->input->post('codigo'));
			$this->objFactibilidad->actualizar(array("ef_estado"=>$estado),array("ef_codigo"=>$codigo));
			echo json_encode(array("result"=>true));
		}
		catch(Exception $e){
			echo json_encode(array("result"=>false,"msg"=>"Ha ocurrido un error inesperado. Por favor, inténtelo nuevamente."));
		}
	}

	public function curso(){
		if($this->input->post()){
			$curso = $this->objCurso->obtener_por_codigo($this->input->post("curso"));
			echo json_encode(["result" => true, "curso" => $curso]);
			exit;
		}else{
			redirect(base_url());
		}
	}

	public function cronograma(){
		if($this->input->post()){
			#validacion
			$this->form_validation->set_rules('dias', 'Días', 'required');
			$this->form_validation->set_rules('horas', 'Horas', 'required');
			$this->form_validation->set_rules('fecha_inicio', 'Fecha Inicio', 'required');
			$this->form_validation->set_rules('fecha_termino', 'Fecha Término', 'required');
			$this->form_validation->set_rules('desde', 'Desde', 'required');
			$this->form_validation->set_rules('hasta', 'Hasta', 'required');
			
			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				$error = validation_errors();
				echo json_encode(array("result"=>false,"msg"=>$error));
				exit;
			}

			/* Diferencia entre dias */
			$fecha_inicio = date("Y-m-d", strtotime(str_replace("/", "-", $this->input->post("fecha_inicio"))));
			$fecha_termino = date("Y-m-d", strtotime(str_replace("/", "-", $this->input->post("fecha_termino"))));
			$diff = strtotime($fecha_termino) - strtotime($fecha_inicio);
			$dias = floor($diff/(60*60*24));

			if($diff <= 0){
				echo json_encode(array("result"=>false,"msg"=>"<div>Fecha Término debe ser mayor a Fecha Inicio</div>"));
				exit;
			}

			/* Diferencia entre horas */
			$diff = strtotime(str_replace("/", "-", $this->input->post("hasta"))) - strtotime(str_replace("/", "-", $this->input->post("desde")));
			$horas = $diff/3600;

			if($diff <= 0){
				echo json_encode(array("result"=>false,"msg"=>"<div>Hora Hasta debe ser mayor a Hora Desde</div>"));
				exit;
			}

			if($this->input->post("desde2") or $this->input->post("hasta2")){
				if(!$this->input->post("hasta2")){
					echo json_encode(array("result"=>false,"msg"=>"<div>Si agrega un segundo Desde, debe agregar un segundo Hasta</div>"));
					exit;
				}
				if(!$this->input->post("desde2")){
					echo json_encode(array("result"=>false,"msg"=>"<div>Si agrega un segundo Hasta, debe agregar un segundo Desde</div>"));
					exit;
				}

				if(strtotime(str_replace("/", "-", $this->input->post("desde2"))) <= strtotime(str_replace("/", "-", $this->input->post("hasta")))){
					echo json_encode(array("result"=>false,"msg"=>"<div>Hora Desde segunda debe ser mayor a la Hora Termino primera</div>"));
					exit;
				}

				/* Diferencia entre horas */
				$diff = strtotime(str_replace("/", "-", $this->input->post("hasta2"))) - strtotime(str_replace("/", "-", $this->input->post("desde2")));
				$horas2 = $diff/3600;

				if($diff <= 0){
					echo json_encode(array("result"=>false,"msg"=>"<div>Hora Hasta debe ser mayor a Hora Desde</div>"));
					exit;
				}
			}else{
				$horas2 = 0;
			}

			/* Generacion de cronograma */
			$html = '<div class="row">';
			$html.= '<div class="col-lg-1"></div>';
			$html.= '<div class="col-lg-1"><b>Día</b></div>';
			$html.= '<div class="col-lg-2"><b>Fecha</b></div>';
			$html.= '<div class="col-lg-1"><b>Desde</b></div>';
			$html.= '<div class="col-lg-1"><b>Hasta</b></div>';
			$html.= '<div class="col-lg-1"><b>Desde</b></div>';
			$html.= '<div class="col-lg-1"><b>Hasta</b></div>';
			$html.= '<div class="col-lg-1"><b>Horas</b></div>';
			$html.= '<div class="col-lg-2"><b>Observación</b></div>';
			$html.= '<div class="col-lg-1"><b>Eliminar</b></div>';
			$html.= '</div>';
			$html.= '<br>';
			$fecha_aux = $fecha_inicio;
			$i = 1;
			$total_horas = 0;
			while(true){
				if(!in_array(date('N', strtotime($fecha_aux)), $this->input->post("dias"))){
					//
				}else{
					$html.= '<div class="row">';
					$html.= '<div class="col-lg-1"><input name="i[]" class="form-control" readonly value="' . ($i) . '"></div>';
					$html.= '<div class="col-lg-1">' . ucfirst(strftime("%A", strtotime($fecha_aux))) . '</div>';
					$html.= '<div class="col-lg-2"><input name="fecha_c[]" class="form-control" readonly value="' . date("d/m/Y", strtotime($fecha_aux)) . '"></div>';
					$html.= '<div class="col-lg-1"><input name="desde_c[]" class="form-control time hora_c" value="' . $this->input->post("desde") . '"></div>';
					$html.= '<div class="col-lg-1"><input name="hasta_c[]" class="form-control time hora_c" value="' . $this->input->post("hasta") . '"></div>';
					$html.= '<div class="col-lg-1"><input name="desde2_c[]" class="form-control time hora_c" value="' . $this->input->post("desde2") . '"></div>';
					$html.= '<div class="col-lg-1"><input name="hasta2_c[]" class="form-control time hora_c" value="' . $this->input->post("hasta2") . '"></div>';
					$html.= '<div class="col-lg-1 total_c">' . ($horas + $horas2) . '</div>';
					$html.= '<div class="col-lg-2"><textarea name="obs_c[]" id="obs_c[]" class="form-control"></textarea></div>';
					$html.= '<div class="col-lg-1"><a title="Eliminar" type="button" class="btn btn-danger btn-sm eliminar" rel="' . ($horas + $horas2) . '"><i class="fa fa-trash"></i></a></div>';
					$html.= '</div>';
					$i++;
					$total_horas = $total_horas + ($horas + $horas2);
				}
				
				$fecha_aux = date("Y-m-d", strtotime($fecha_aux . " +1 day"));
				if(strtotime($fecha_aux) > strtotime($fecha_termino)) break;	
			}

			$html.= '<div class="row">';
			$html.= '<div class="col-lg-1"><a href="#" id="agregar_c">Agregar</a></div>';
			$html.= '<div class="col-lg-1"></div>';
			$html.= '<div class="col-lg-2"></div>';
			$html.= '<div class="col-lg-1"></div>';
			$html.= '<div class="col-lg-1"></div>';
			$html.= '<div class="col-lg-1"></div>';
			$html.= '<div class="col-lg-1"><b>Total</b></div>';
			$html.= '<div class="col-lg-2" style="color: ';
			if($total_horas != $this->input->post("horas")) $html.= 'red';
			else $html.= 'green';
			$html.= ';" id="total_c">' . ($total_horas) . '</div>';
			$html.= '<div class="col-lg-1"></div>';
			$html.= '</div>';

			echo json_encode(array("result"=>true,"html"=>$html));
			exit;
		}else{
			redirect(base_url());
		}
	}

	public function agregar_hora(){
		$fecha_aux = $this->input->post("fecha_c");
		$fecha_aux = end($fecha_aux);
		$fecha_aux = date("Y-m-d", strtotime(str_replace("/", "-", $fecha_aux) . " +1 day"));
		$i = $this->input->post("i");
		$i = end($i) + 1;
		$diff = strtotime(str_replace("/", "-", $this->input->post("hasta"))) - strtotime(str_replace("/", "-", $this->input->post("desde")));
		$horas = $diff/3600;
		$diff = strtotime(str_replace("/", "-", $this->input->post("hasta2"))) - strtotime(str_replace("/", "-", $this->input->post("desde2")));
		$horas2 = $diff/3600;
		while(true){
			if(!in_array(date('N', strtotime($fecha_aux)), $this->input->post("dias"))){
				//
			}else{
				$html = '<div class="row">';
				$html.= '<div class="col-lg-1"><input name="i[]" class="form-control" readonly value="' . ($i) . '"></div>';
				$html.= '<div class="col-lg-1">' . ucfirst(strftime("%A", strtotime($fecha_aux))) . '</div>';
				$html.= '<div class="col-lg-2"><input name="fecha_c[]" class="form-control" readonly value="' . date("d/m/Y", strtotime($fecha_aux)) . '"></div>';
				$html.= '<div class="col-lg-1"><input name="desde_c[]" class="form-control time hora_c" value="' . $this->input->post("desde") . '"></div>';
				$html.= '<div class="col-lg-1"><input name="hasta_c[]" class="form-control time hora_c" value="' . $this->input->post("hasta") . '"></div>';
				$html.= '<div class="col-lg-1"><input name="desde2_c[]" class="form-control time hora_c" value="' . $this->input->post("desde2") . '"></div>';
				$html.= '<div class="col-lg-1"><input name="hasta2_c[]" class="form-control time hora_c" value="' . $this->input->post("hasta2") . '"></div>';
				$html.= '<div class="col-lg-1">' . ($horas + $horas2) . '</div>';
				$html.= '<div class="col-lg-2"><textarea name="obs_c[]" id="obs_c[]" class="form-control"></textarea></div>';
				$html.= '<div class="col-lg-1"><a title="Eliminar" type="button" class="btn btn-danger btn-sm eliminar" rel="' . ($horas + $horas2) . '"><i class="fa fa-trash"></i></a></div>';
				$html.= '</div>';
				$i++;
				break;
			}
			
			$fecha_aux = date("Y-m-d", strtotime($fecha_aux . " +1 day"));
		}
		$total_horas = $this->input->post("total_horas") + ($horas + $horas2);
		$html.= '<div class="row">';
		$html.= '<div class="col-lg-1"><a href="#" id="agregar_c">Agregar</a></div>';
		$html.= '<div class="col-lg-1"></div>';
		$html.= '<div class="col-lg-2"></div>';
		$html.= '<div class="col-lg-1"></div>';
		$html.= '<div class="col-lg-1"></div>';
		$html.= '<div class="col-lg-1"></div>';
		$html.= '<div class="col-lg-1"><b>Total</b></div>';
		$html.= '<div class="col-lg-2" style="color: ';
		if($total_horas != $this->input->post("horas")) $html.= 'red';
		else $html.= 'green';
		$html.= ';" id="total_c">' . ($total_horas) . '</div>';
		$html.= '<div class="col-lg-1"></div>';
		$html.= '</div>';
		echo json_encode(["result"=>true,"html"=>$html]);
		exit;
	}

	public function agregar(){
		if($this->input->post()){
			#validacion
			$this->form_validation->set_rules('nombre', 'Nombre Diploma', 'required');
			$this->form_validation->set_rules('direccion', 'Dirección Realización', 'required');
			$this->form_validation->set_rules('obs', 'Observación', 'required');
			$this->form_validation->set_rules('tipo_manual', 'Tipo Manual', 'required');
			$this->form_validation->set_rules('curso', 'Curso', 'required');
			$this->form_validation->set_rules('tipo_curso', 'Tipo Curso', 'required');
			$this->form_validation->set_rules('empresa', 'Cliente', 'required');

			$this->form_validation->set_rules('fecha_c', 'Fecha Cronograma', 'required');
			$this->form_validation->set_rules('desde_c', 'Desde Cronograma', 'required');
			$this->form_validation->set_rules('hasta_c', 'Hasta Cronograma', 'required');
			$this->form_validation->set_rules('obs_c', 'Observación Cronograma', 'required');

			$this->form_validation->set_rules('obs_t', 'Observación Técnica', 'required');
			$this->form_validation->set_rules('sala', 'Sala', 'required');

			$this->form_validation->set_rules('obs_a', 'Observación Académica', 'required');
			$this->form_validation->set_rules('usuario', 'Relatores', 'required');

			$this->form_validation->set_rules('obs_d', 'Observación Adquisición', 'required');
			$this->form_validation->set_rules('coctel', 'Coctel', 'required');
			
			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				$error = validation_errors();
				echo json_encode(array("result"=>false,"msg"=>$error));
				exit;
			}

			$total_horas = 0;
			$fecha_c = $this->input->post("fecha_c");
			$hora_inicio_c = $this->input->post("desde_c");
			$hora_termino_c = $this->input->post("hasta_c");
			$hora_inicio2_c = $this->input->post("desde2_c");
			$hora_termino2_c = $this->input->post("hasta2_c");
			$obs_c = $this->input->post("obs_c");

			for($i=0; $i<count($fecha_c); $i++){
				$total_horas+= (strtotime($hora_termino_c[$i]) - strtotime($hora_inicio_c[$i])) + (strtotime($hora_termino2_c[$i]) - strtotime($hora_inicio2_c[$i]));
			}

			$total_horas = $total_horas/3600;

			if($total_horas != $this->input->post("horas")){
				echo json_encode(array("result"=>false,"msg"=>"<div>El curso debe tener " . $this->input->post("horas") . " horas.</div>"));
				exit;
			}

			if($this->input->post("usuario")[0] === $this->input->post("usuario")[1]){
				echo json_encode(["result" => false, "msg" => "<div>El relator no se puede repetir.</div>"]);
				exit;
			}

			$estudio_factibilidad = [
				"ef_codigo" => $this->objFactibilidad->getLastId(),
				"ef_fecha_emision" => date("Y-m-d"),
				"ef_nombre_diploma" => $this->input->post("nombre"),
				"ef_direccion_realizacion" => $this->input->post("direccion"),
				"ef_fecha_inicio" => $fecha_c[0],
				"ef_fecha_termino" => end($fecha_c),
				"ef_obs" => $this->input->post("obs"),
				"tm_codigo" => $this->input->post("tipo_manual"),
				"cu_codigo" => $this->input->post("curso"),
				"tc_codigo" => $this->input->post("tipo_curso"),
				"us_codigo" => $this->session->userdata("usuario")->codigo
			];

			if($this->objFactibilidad->insertar($estudio_factibilidad)){
				/* Agregar cronogramas */
				for($i =0; $i < count($fecha_c) ; $i++){
					$cronograma = [
						"cr_codigo" => $this->objCronograma->getLastId(),
						"cr_fecha" => date("Y-m-d", strtotime(str_replace("/", "-", $fecha_c[$i]))),
						"cr_hora_inicio_d" => date("H:i:s", strtotime($hora_inicio_c[$i])),
						"cr_hora_fin_d" => date("H:i:s", strtotime($hora_termino_c[$i])),
						"cr_hora_inicio_t" => date("H:i:s", strtotime($hora_inicio2_c[$i])),
						"cr_hora_fin_t" => date("H:i:s", strtotime($hora_termino2_c[$i])),
						"cr_obs" => $obs_c[$i],
						"ef_codigo" => $estudio_factibilidad["ef_codigo"]
					];
					$this->objCronograma->insertar($cronograma);
				}

				/* Agregar Requerimientos */

				$requerimientos_tecnicos = [
					"rt_codigo" => $this->objRequerimientoTecnico->getLastId(),
					"rt_obs" => $this->input->post("obs_t"),
					"rt_computadores" => ($this->input->post("computadores") ? $this->input->post("computadores") : "f"),
					"rt_proyector" => ($this->input->post("proyector") ? $this->input->post("proyector") : "f"),
					"rt_pizarra" => ($this->input->post("pizarra") ? $this->input->post("pizarra") : "f"),
					"rt_arriendo" => ($this->input->post("arriendo") ? $this->input->post("arriendo") : "f"),
					"rt_sala" => $this->input->post("sala"),
					"ef_codigo" => $estudio_factibilidad["ef_codigo"]
				];

				$this->objRequerimientoTecnico->insertar($requerimientos_tecnicos);

				$requerimientos_academicos = [
					"ra_codigo" => $this->objRequerimientoAcademico->getLastId(),
					"ra_obs" => $this->input->post("obs_a"),
					"ef_codigo" => $estudio_factibilidad["ef_codigo"]
				];

				$this->objRequerimientoAcademico->insertar($requerimientos_academicos);

				foreach($this->input->post("usuario") as $usuario){
					$relator = [
						"ra_codigo" => $requerimientos_academicos["ra_codigo"],
						"us_codigo" => $usuario
					];
					$this->objRelator->insertar($relator);
				}

				$requerimientos_adquisicion = [
					"rd_codigo" => $this->objRequerimientoAdquisicion->getLastId(),
					"rd_obs" => $this->input->post("obs_d"),
					"ef_codigo" => $estudio_factibilidad["ef_codigo"]
				];

				$this->objRequerimientoAdquisicion->insertar($requerimientos_adquisicion);

				if($this->input->post("coctel")){
					$fecha_coctel = strtotime(str_replace("/", "-", $this->input->post("fecha_coctel"))) + strtotime($this->input->post("hora_coctel"));
					$coctel = [
						"cc_codigo" => $this->objCoctel->getLastId(),
						"cc_direccion" => $this->input->post("direccion_coctel"),
						"cc_fecha" => date("Y-m-d H:i:s", $fecha_coctel),
						"rd_codigo" => $requerimientos_adquisicion["rd_codigo"]
					];
					$this->objCoctel->insertar($coctel);
				}
				
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

			#TIME
			$this->layout->js('bower_components/pickadate/lib/picker.js');
			$this->layout->js('bower_components/pickadate/lib/picker.time.js');
			$this->layout->css('bower_components/pickadate/lib/themes/classic.css');
			$this->layout->css('bower_components/pickadate/lib/themes/classic.time.css');
			$this->layout->js('assets/js/sistema/time.js');

			$this->layout->js('assets/js/sistema/agregar.js');
			$this->layout->js('assets/js/sistema/curso.js');
			$this->layout->js('assets/js/sistema/cronograma.js');

			$contenido = [
				"tipo_cursos" => $this->objTipoCurso->listar(),
				"sucursales" => $this->objSucursal->listar(),
				"cursos" => $this->objCurso->listar(
					"cu_fecha_vencimiento > '" . date("Y-m-d") . "'" 
				),
				"empresas" => $this->objEmpresa->listar(),
				"tipo_manuales" => $this->objTipoManual->listar(),
				"usuarios" => $this->objUsuario->listar() //Filtrar solo relatores y activos
			];

			$this->layout->view('agregar', $contenido);
		}
	}

	public function editar($codigo = false){
		if($this->input->post()){
			#validacion
			$this->form_validation->set_rules('nombre', 'Nombre Diploma', 'required');
			$this->form_validation->set_rules('direccion', 'Dirección Realización', 'required');
			$this->form_validation->set_rules('obs', 'Observación', 'required');
			$this->form_validation->set_rules('tipo_manual', 'Tipo Manual', 'required');
			$this->form_validation->set_rules('curso', 'Curso', 'required');
			$this->form_validation->set_rules('tipo_curso', 'Tipo Curso', 'required');
			$this->form_validation->set_rules('empresa', 'Cliente', 'required');

			$this->form_validation->set_rules('fecha_c', 'Fecha Cronograma', 'required');
			$this->form_validation->set_rules('desde_c', 'Desde Cronograma', 'required');
			$this->form_validation->set_rules('hasta_c', 'Hasta Cronograma', 'required');
			$this->form_validation->set_rules('obs_c', 'Observación Cronograma', 'required');

			$this->form_validation->set_rules('obs_t', 'Observación Técnica', 'required');
			$this->form_validation->set_rules('sala', 'Sala', 'required');

			$this->form_validation->set_rules('obs_a', 'Observación Académica', 'required');
			$this->form_validation->set_rules('usuario', 'Relatores', 'required');

			$this->form_validation->set_rules('obs_d', 'Observación Adquisición', 'required');
			$this->form_validation->set_rules('coctel', 'Coctel', 'required');
			
			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				$error = validation_errors();
				echo json_encode(array("result"=>false,"msg"=>$error));
				exit;
			}

			$total_horas = 0;
			$fecha_c = $this->input->post("fecha_c");
			$hora_inicio_c = $this->input->post("desde_c");
			$hora_termino_c = $this->input->post("hasta_c");
			$hora_inicio2_c = $this->input->post("desde2_c");
			$hora_termino2_c = $this->input->post("hasta2_c");
			$obs_c = $this->input->post("obs_c");

			for($i=0; $i<count($fecha_c); $i++){
				$total_horas+= (strtotime($hora_termino_c[$i]) - strtotime($hora_inicio_c[$i])) + (strtotime($hora_termino2_c[$i]) - strtotime($hora_inicio2_c[$i]));
			}

			$total_horas = $total_horas/3600;

			if($total_horas != $this->input->post("horas")){
				echo json_encode(array("result"=>false,"msg"=>"<div>El curso debe tener " . $this->input->post("horas") . " horas.</div>"));
				exit;
			}

			if($this->input->post("usuario")[0] === $this->input->post("usuario")[1]){
				echo json_encode(["result" => false, "msg" => "<div>El relator no se puede repetir.</div>"]);
				exit;
			}

			$estudio_factibilidad = [
				"ef_fecha_emision" => date("Y-m-d"),
				"ef_nombre_diploma" => $this->input->post("nombre"),
				"ef_direccion_realizacion" => $this->input->post("direccion"),
				"ef_fecha_inicio" => $fecha_c[0],
				"ef_fecha_termino" => end($fecha_c),
				"ef_obs" => $this->input->post("obs"),
				"tm_codigo" => $this->input->post("tipo_manual"),
				"cu_codigo" => $this->input->post("curso"),
				"tc_codigo" => $this->input->post("tipo_curso"),
				"us_codigo" => $this->session->userdata("usuario")->codigo
			];

			if($this->objFactibilidad->actualizar($estudio_factibilidad, ["ef_codigo" => $this->input->post("codigo")])){
				/* Editar cronogramas */
				for($i = 0; $i < count($fecha_c) ; $i++){
					$cronograma = [
						"cr_fecha" => date("Y-m-d", strtotime(str_replace("/", "-", $fecha_c[$i]))),
						"cr_hora_inicio_d" => date("H:i:s", strtotime($hora_inicio_c[$i])),
						"cr_hora_fin_d" => date("H:i:s", strtotime($hora_termino_c[$i])),
						"cr_hora_inicio_t" => date("H:i:s", strtotime($hora_inicio2_c[$i])),
						"cr_hora_fin_t" => date("H:i:s", strtotime($hora_termino2_c[$i])),
						"cr_obs" => $obs_c[$i],
						"ef_codigo" => $this->input->post("codigo")
					];
					$this->objCronograma->actualizar($cronograma, ["cr_codigo" => $this->input->post("i")[$i]]);
				}

				/* Editar Requerimientos */

				$requerimientos_tecnicos = [
					"rt_obs" => $this->input->post("obs_t"),
					"rt_computadores" => ($this->input->post("computadores") ? $this->input->post("computadores") : "f"),
					"rt_proyector" => ($this->input->post("proyector") ? $this->input->post("proyector") : "f"),
					"rt_pizarra" => ($this->input->post("pizarra") ? $this->input->post("pizarra") : "f"),
					"rt_arriendo" => ($this->input->post("arriendo") ? $this->input->post("arriendo") : "f"),
					"rt_sala" => $this->input->post("sala"),
					"ef_codigo" => $this->input->post("codigo")
				];

				$this->objRequerimientoTecnico->actualizar($requerimientos_tecnicos, ["rt_codigo" => $this->input->post("codigo_rt")]);

				$requerimientos_academicos = [
					"ra_obs" => $this->input->post("obs_a"),
					"ef_codigo" => $this->input->post("codigo")
				];

				$this->objRequerimientoAcademico->actualizar($requerimientos_academicos, ["ra_codigo" => $this->input->post("codigo_ra")]);

				$this->objRelator->eliminar(["ra_codigo" => $this->input->post("codigo_ra")]);
				foreach($this->input->post("usuario") as $usuario){
					$relator = [
						"ra_codigo" => $this->input->post("codigo_ra"),
						"us_codigo" => $usuario
					];
					$this->objRelator->insertar($relator);
				}

				$requerimientos_adquisicion = [
					"rd_obs" => $this->input->post("obs_d"),
					"ef_codigo" => $this->input->post("codigo")
				];

				$this->objRequerimientoAdquisicion->actualizar($requerimientos_adquisicion, ["rd_codigo" => $this->input->post("codigo_rd")]);

				if($this->input->post("coctel")){
					$fecha_coctel = strtotime(str_replace("/", "-", $this->input->post("fecha_coctel")) . " " . $this->input->post("hora_coctel"));
					$coctel = [
						"cc_direccion" => $this->input->post("direccion_coctel"),
						"cc_fecha" => date("Y-m-d H:i:s", $fecha_coctel),
						"rd_codigo" => $this->input->post("codigo_rd")
					];
					$this->objCoctel->actualizar($coctel, ["cc_codigo" => $this->input->post("codigo_coctel")]);
				}
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"<div>Error al guardar en la base de datos.</div>"));
				exit;
			}
		}else{
			#title
			$this->layout->title('Editar Estudio Factibilidad');
			
			#metas
			$this->layout->setMeta('title','Editar Estudio Factibilidad');
			$this->layout->setMeta('description','Editar Estudio Factibilidad');
			$this->layout->setMeta('keywords','Editar Estudio Factibilidad');

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

			#TIME
			$this->layout->js('bower_components/pickadate/lib/picker.js');
			$this->layout->js('bower_components/pickadate/lib/picker.time.js');
			$this->layout->css('bower_components/pickadate/lib/themes/classic.css');
			$this->layout->css('bower_components/pickadate/lib/themes/classic.time.css');
			$this->layout->js('assets/js/sistema/time.js');

			$this->layout->js('assets/js/sistema/editar.js');
			$this->layout->js('assets/js/sistema/curso.js');
			$this->layout->js('assets/js/sistema/cronograma.js');

			$estudio_factibilidad = $this->objFactibilidad->obtener_por_codigo($codigo);
			if($estudio_factibilidad->estado) redirect(base_url() . "estudio-factibilidad/");
			$contenido = [
				"estudio_factibilidad" => $estudio_factibilidad,
				"tipo_cursos" => $this->objTipoCurso->listar(),
				"sucursales" => $this->objSucursal->listar(),
				"cursos" => $this->objCurso->listar(
					"cu_fecha_vencimiento > '" . date("Y-m-d") . "'" 
				),
				"empresas" => $this->objEmpresa->listar(),
				"tipo_manuales" => $this->objTipoManual->listar(),
				"cronogramas" => $this->objCronograma->listar(["ef_codigo" => $codigo]),
				"requerimiento_tecnico" => $this->objRequerimientoTecnico->obtener(["ef_codigo" => $codigo]),
				"requerimiento_academico" => $this->objRequerimientoAcademico->obtener(["ef_codigo" => $codigo]),
				"relatores" => [],
				"requerimiento_adquisicion" => $this->objRequerimientoAdquisicion->obtener(["ef_codigo" => $codigo]),
				"usuarios" => $this->objUsuario->listar() //Filtrar solo relatores y activos
			];

			$relatores = $this->objRelator->listar(["ra_codigo" => $contenido["requerimiento_academico"]->codigo]);
			foreach($relatores as $relator){
				$contenido["relatores"][] = $relator->us_codigo;
			}

			$contenido["coctel"] = $this->objCoctel->obtener(["rd_codigo" => $contenido["requerimiento_adquisicion"]->codigo]);

			//die(print_array($contenido));

			$this->layout->view('editar', $contenido);
		}
	}
	
}