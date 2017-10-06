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
		$this->load->model("modelo_presupuesto", "objPresupuesto");
		$this->load->model("modelo_costos_operativos", "objCostos");
		$this->load->model("modelo_empresa_estudio", "objCliente");
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
	
	public function visar(){
		try{
			list($codigo,$estado) = explode('-',$this->input->post('codigo'));
			$this->objFactibilidad->actualizar(array("ef_visado"=>$estado),array("ef_codigo"=>$codigo));
			echo json_encode(array("result"=>true));
		}
		catch(Exception $e){
			echo json_encode(array("result"=>false,"msg"=>"Ha ocurrido un error inesperado. Por favor, inténtelo nuevamente."));
		}
	}

	public function eliminar(){
		try{
			$this->objCronograma->eliminar(["ef_codigo" => $this->input->post('codigo')]);
			$this->objRequerimientoTecnico->eliminar(["ef_codigo" => $this->input->post('codigo')]);
			$requerimiento_academico = $this->objRequerimientoAcademico->obtener(["ef_codigo" => $this->input->post('codigo')]);
			$this->objRelator->eliminar(["ra_codigo" => $requerimiento_academico->codigo]);
			$this->objRequerimientoAcademico->eliminar(["ef_codigo" => $this->input->post('codigo')]);
			$requerimiento_adquisicion = $this->objRequerimientoAdquisicion->obtener(["ef_codigo" => $this->input->post('codigo')]);
			$this->objCoctel->eliminar(["rd_codigo" => $requerimiento_adquisicion->codigo]);
			$this->objRequerimientoAdquisicion->eliminar(["ef_codigo" => $this->input->post('codigo')]);
			$this->objFactibilidad->eliminar(["ef_codigo" => $this->input->post('codigo')]);
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
				/* Agregar Cliente */
				$cliente = [
					"ef_codigo" => $estudio_factibilidad["ef_codigo"],
					"em_codigo" => $this->input->post("empresa")
				];
				$this->objCliente->insertar($cliente);
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

				/* Presupuestos */
				$presupuesto = [
					"pr_codigo" => $this->objPresupuesto->getLastId(),
					"pr_ingreso_ventas" => $this->input->post("ingreso_ventas"),
					"pr_costos_directos" => $this->input->post("costos_directos"),
					"pr_costos_fijos" => $this->input->post("costos_fijos"),
					"pr_comision_asesor" => $this->input->post("comision_asesor"),
					"pr_utilidad_bruta" => $this->input->post("utilidad_bruta"),
					"pr_utilidad_bruta_porcentaje" => $this->input->post("utilidad_bruta_p"),
					"pr_valor_hora_relator" => $this->input->post("valor_hh_r"),
					"pr_beneficio_neto" => $this->input->post("beneficio_neto"),
					"pr_costos_fijos_porcentaje" => $this->input->post("porcentaje_cf"),
					"pr_comision_asesor_porcentaje" => $this->input->post("porcentaje_ca"),
					"ef_codigo" => $estudio_factibilidad["ef_codigo"]
				];

				$this->objPresupuesto->insertar($presupuesto);

				for($i = 0; $i < count($this->input->post("unitario")); $i++){
					$costos_operativos = [
						"ct_codigo" => $this->objCostos->getLastId(),
						"ct_nombre" => $this->input->post("nombre_costo")[$i],
						"ct_unitario" => $this->input->post("unotario")[$i],
						"ct_adicional" => $this->input->post("adicional")[$i],
						"ct_subtotal" => $this->input->post("subtotal")[$i],
						"ct_detalle" => $this->input->post("detalle_costo")[$i],
						"ct_cantidad" => $this->input->post("cantidad_costo")[$i],
						"ct_porcentaje" => $this->input->post("porcentaje")[$i],
						"pr_codigo" => $presupuesto["pr_codigo"]
					];
					$this->objCostos->insertar($costos_operativos);
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
			$this->layout->js('assets/js/sistema/presupuesto.js');

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

			$contenido["costos_fijos"] = ["Hora-Relator", "Manuales/Pendrive", "Blocks", "Diplomas/Sobres", "Coffee Break", "Lápiz Corp", "Materiales/Insumos", "Arriendo Sala", "Arriendo Equipos", "Traslado"];

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
				/* Agregar Cliente */
				$cliente = [
					"em_codigo" => $this->input->post("empresa")
				];
				$this->objCliente->actualizar($cliente, ["ef_codigo" => $this->input->post("codigo")]);

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

				/* Presupuestos */
				$presupuesto = [
					"pr_ingreso_ventas" => $this->input->post("ingreso_ventas"),
					"pr_costos_directos" => $this->input->post("costos_directos"),
					"pr_costos_fijos" => $this->input->post("costos_fijos"),
					"pr_comision_asesor" => $this->input->post("comision_asesor"),
					"pr_utilidad_bruta" => $this->input->post("utilidad_bruta"),
					"pr_utilidad_bruta_porcentaje" => $this->input->post("utilidad_bruta_p"),
					"pr_valor_hora_relator" => $this->input->post("valor_hh_r"),
					"pr_beneficio_neto" => $this->input->post("beneficio_neto"),
					"pr_costos_fijos_porcentaje" => $this->input->post("porcentaje_cf"),
					"pr_comision_asesor_porcentaje" => $this->input->post("porcentaje_ca"),
					"ef_codigo" => $this->input->post("codigo")
				];

				$this->objPresupuesto->actualizar($presupuesto, ["pr_codigo" => $this->input->post("codigo_presupuesto")]);

				for($i = 0; $i < count($this->input->post("unitario")); $i++){
					$costos_operativos = [
						"ct_nombre" => $this->input->post("nombre_costo")[$i],
						"ct_unitario" => $this->input->post("unotario")[$i],
						"ct_adicional" => $this->input->post("adicional")[$i],
						"ct_subtotal" => $this->input->post("subtotal")[$i],
						"ct_detalle" => $this->input->post("detalle_costo")[$i],
						"ct_cantidad" => $this->input->post("cantidad_costo")[$i],
						"ct_porcentaje" => $this->input->post("porcentaje")[$i],
						"pr_codigo" => $this->input->post("codigo_presupuesto")
					];
					$this->objCostos->actualizar($costos_operativos, ["ct_codigo" => $this->input->post("codigo_costo")[$i]]);
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
			$this->layout->js('assets/js/sistema/presupuesto.js');

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
				"presupuesto" => $this->objPresupuesto->obtener(["ef_codigo" => $codigo]),
				"usuarios" => $this->objUsuario->listar() //Filtrar solo relatores y activos
			];

			$relatores = $this->objRelator->listar(["ra_codigo" => $contenido["requerimiento_academico"]->codigo]);
			foreach($relatores as $relator){
				$contenido["relatores"][] = $relator->us_codigo;
			}

			$contenido["coctel"] = $this->objCoctel->obtener(["rd_codigo" => $contenido["requerimiento_adquisicion"]->codigo]);

			$contenido["costos_operativos"] = $this->objCostos->obtener(["pr_codigo" => $contenido["presupuesto"]->codigo]);

			$this->layout->view('editar', $contenido);
		}
	}

	public function libro_clase(){
		if(true){
			$html = '
			<table width="86%" align="center" border="0">
				<tr>
					<th width="50%" scope="col">
					</th>
					<th width="10%" scope="col">&nbsp;</th>
					<th width="10%" scope="col">&nbsp;</th>
					<th width="10%" scope="col">&nbsp;</th>
					<th width="20%" scope="col" align="center" valign="bottom">
					<div class="bordes">
						10
					</div>
					&nbsp;&nbsp;&nbsp;&nbsp;CORRELATIVO
					</th>
				</tr>
		  	</table>
		  	<br>
		  	<table width="80%" border="0" align="center">
				<tr>
				<th scope="col" ><u>LIBRO DE CONTROL DE CLASES</u></th>
				</tr>
		  	</table><br>
		  	<table width="97%" border="0" align="center">
				<tr>
					<td width="14%">NOMBRE OTEC</td>
					<th width="2%" scope="col">:</th>
					<th colspan="2" scope="col">CRECIC</th>
					<th colspan="2" scope="col">&nbsp;</th>
					<th width="19%" scope="col">&nbsp;</th>
				</tr>
				<tr>
					<td width="30%">NOMBRE ACTIVIDAD DE CAPACITACIÓN</td>
					<th>:</th>
					<th colspan="2">Nombre</th>
					<td colspan="2">&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td colspan="2">&nbsp;</td>
					<td width="7%">HORAS: </td>
					<td width="12%">20</td>
					<td>&nbsp; </td>
				</tr>
				<tr>
					<td width="30%">CODIGO AUTORIZADO POR SENCE</td>
					<td>:</td>
					<td colspan="2">121212</td>
					<td colspan="2">&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td valign="top" >FECHA DE EJECUCIÓN</td>
					<td valign="top">:</td>
					<td width="8%" ><div class="titulo1">INICIO<br>TERMINO</b></td>
					<td width="38%"><div class="titulo1">:
					10/10/1010<br>
					:
					20/20/2020
					</div></td>
					<td colspan="2" rowspan="2">ID:
					</td>
				</tr>
				<tr>
					<td>LUGAR DE EJECUCIÓN</td>
					<td>:</td>
					<td colspan="2">asdsads</td>
					<td colspan="2">&nbsp;</td>
					<td><br></td>
				</tr>
				<tr>
					<td>HORARIO</td>
					<td>:</td>
					<td colspan="2">20:20</td>
					<td colspan="2">&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td colspan="2">&nbsp;</td>
					<td colspan="2">&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>NOMBRE INSTRUCTOR(ES)</td>
					<td>:</td> 
					<th colspan="2">El profe</th>
					<td>&nbsp;</td>
				</tr>
			</table>';

			$rutaPdf = "/crecic/sic/assets/files/";
			if(!file_exists($_SERVER['DOCUMENT_ROOT'].$rutaPdf))
				mkdir($_SERVER['DOCUMENT_ROOT'].$rutaPdf, 0777);
			$rutaPdf .= "pdf/";
			if(!file_exists($_SERVER['DOCUMENT_ROOT'].$rutaPdf))
				mkdir($_SERVER['DOCUMENT_ROOT'].$rutaPdf, 0777);
			
			$nombrePdf = "pdf".time().'.pdf';
			ob_start();
			$mpdf=new mPDF('utf-8','','','',0,0,0,0,6,3);
			$mpdf->SetDisplayMode('fullpage');
			$mpdf->SetTitle('Libro Clases');
			$mpdf->SetAuthor('Crecic Ltda');
			$mpdf->WriteHTML($html, 2);
			
			$mpdf->Output($_SERVER['DOCUMENT_ROOT'].$rutaPdf.$nombrePdf,'F');
			$rutaPdf = base_url() . "assets/files/pdf/";
			redirect($rutaPdf.$nombrePdf);
			exit;
		}else{
			redirect(base_url());
		}
	}

	public function pdf($codigo = false){
		if($codigo){
			$estudio_factibilidad = $this->objFactibilidad->obtener_por_codigo($codigo);
			$cronogramas = $this->objCronograma->listar(["ef_codigo" => $codigo]);
			$requerimiento_tecnico = $this->objRequerimientoTecnico->obtener(["ef_codigo" => $codigo]);
			$requerimiento_academico = $this->objRequerimientoAcademico->obtener(["ef_codigo" => $codigo]);
			$relatores = $this->objRelator->listar(["ra_codigo" => $requerimiento_academico->codigo]);
			$requerimiento_adquisicion = $this->objRequerimientoAdquisicion->obtener(["ef_codigo" => $codigo]);
			$coctel = $this->objCoctel->obtener(["rd_codigo" => $requerimiento_adquisicion->codigo]);

			$html = '<div style="padding: 20px;">';

			$html.= '<table style="width: 100%;">';

			$html.= '<tr>';
			$html.= '<td><img src="assets/img/logo.png" width="15%"></td>';
			$html.= '<td></td>';
			$html.= '<td></td>';
			$html.= '<td><h1>Estudio de Factibilidad</h1></td>';
			$html.= '<td></td>';
			$html.= '<td></td>';
			$html.= '</tr>';

			$html.= '<tr>';
			$html.= '<td><b>Nombre Diploma</b></td>';
			$html.= '<td>' . $estudio_factibilidad->nombre_diploma . '</td>';
			$html.= '<td><b>Correlativo</b></td>';
			$html.= '<td>' . $estudio_factibilidad->codigo . '</td>';
			$html.= '<td><b>Fecha Emisión</b></td>';
			$html.= '<td>' . date("d/m/Y", strtotime($estudio_factibilidad->fecha_emision)) . '</td>';
			$html.= '</tr>';

			$html.= '<tr>';
			$html.= '<td><b>Fecha Inicio</b></td>';
			$html.= '<td>' . date("d/m/Y", strtotime($estudio_factibilidad->fecha_inicio)) . '</td>';
			$html.= '<td><b>Fecha Termino</b></td>';
			$html.= '<td>' . date("d/m/Y", strtotime($estudio_factibilidad->fecha_emision)) . '</td>';
			$html.= '<td><b>Observación</b></td>';
			$html.= '<td>' . $estudio_factibilidad->obs . '</td>';
			$html.= '</tr>';
			
			$html.= '<tr>';
			$html.= '<td><b>Tipo Manual</b></td>';
			$html.= '<td>' . $estudio_factibilidad->tipo_manual->nombre . '</td>';
			$html.= '<td><b>Asesor</b></td>';
			$html.= '<td>' . $estudio_factibilidad->usuario->nombres . ' ' . $estudio_factibilidad->usuario->apellido_paterno . ' ' . $estudio_factibilidad->usuario->apellido_materno . '</td>';
			$html.= '<td><b>Tipo Curso</b></td>';
			$html.= '<td>' . $estudio_factibilidad->tipo_curso->nombre . '</td>';
			$html.= '</tr>';
			
			$html.= '<tr>';
			$html.= '<td><b>Curso Sence Código</b></td>';
			$html.= '<td>' . $estudio_factibilidad->curso->sence . '</td>';
			$html.= '<td><b>Curso Sence Nombre</b></td>';
			$html.= '<td>' . $estudio_factibilidad->curso->nombre . '</td>';
			$html.= '<td><b>Horas</b></td>';
			$html.= '<td>' . $estudio_factibilidad->curso->horas . '</td>';
			$html.= '<td><b>Alumnos</b></td>';
			$html.= '<td>' . $estudio_factibilidad->curso->alumnos . '</td>';
			$html.= '</tr>';

			$html.= '</table>';

			$html.= '<table style="width: 100%">';

			$html.= '<tr>';
			$html.= '<td><h1>Cronograma</h1></td>';
			$html.= '</tr>';
			
			foreach($cronogramas as $cronograma){
				$html.= '<tr>';
				$html.= '<td><b>' . $cronograma->codigo . '</b></td>';
				$html.= '<td>' . date('d/m/Y', strtotime($cronograma->fecha)) . '</td>';
				$html.= '<td>' . date('H:i', strtotime($cronograma->hora_inicio_d)) . '</td>';
				$html.= '<td>' . date('H:i', strtotime($cronograma->hora_fin_d)) . '</td>';
				$html.= '<td>' . date('H:i', strtotime($cronograma->hora_inicio_t)) . '</td>';
				$html.= '<td>' . date('H:i', strtotime($cronograma->hora_fin_t)) . '</td>';
				$html.= '<td>' . $cronograma->obs . '</td>';
				$html.= '</tr>';
			}
			
			$html.= '</table>';

			$html.= '<table style="width: 100%">';
			
			$html.= '<tr>';
			$html.= '<td><h1>Requerimientos</h1></td>';
			$html.= '</tr>';

			$html.= '<tr>';
			$html.= '<td><b>Requerimiento Técnico</b></td>';
			$html.= '</tr>';
			
			$html.= '<tr>';
			$html.= '<td><b>Observación</b></td>';
			$html.= '<td>' . $requerimiento_tecnico->obs . '</td>';
			$html.= '<td><b>Respuesta</b></td>';
			$html.= '<td>' . $requerimiento_tecnico->respuesta . '</td>';
			$html.= '<td><b>Sala</b></td>';
			$html.= '<td>' . $requerimiento_tecnico->sala . '</td>';
			$html.= '</tr>';

			$html.= '<tr>';
			$html.= '<td><b>Computadores</b></td>';
			$html.= '<td>' . ($requerimiento_tecnico->computadores ? 'Sí' : 'No') . '</td>';
			$html.= '<td><b>Proyector</b></td>';
			$html.= '<td>' . ($requerimiento_tecnico->proyector ? 'Sí' : 'No') . '</td>';
			$html.= '<td><b>Pizarra</b></td>';
			$html.= '<td>' . ($requerimiento_tecnico->pizarra ? 'Sí' : 'No') . '</td>';
			$html.= '<td><b>Arriendo</b></td>';
			$html.= '<td>' . ($requerimiento_tecnico->arriendo ? 'Sí' : 'No') . '</td>';
			$html.= '</tr>';

			$html.= '<tr>';
			$html.= '<td><b>Requerimiento Académico</b></td>';
			$html.= '</tr>';
			
			$html.= '<tr>';
			$html.= '<td><b>Observación</b></td>';
			$html.= '<td>' . $requerimiento_academico->obs . '</td>';
			$html.= '<td><b>Respuesta</b></td>';
			$html.= '<td>' . $requerimiento_academico->respuesta . '</td>';
			$html.= '</tr>';

			$html.= '<tr>';
			$html.= '<td><b>Requerimiento Adquisición</b></td>';
			$html.= '</tr>';
			
			$html.= '<tr>';
			$html.= '<td><b>Observación</b></td>';
			$html.= '<td>' . $requerimiento_adquisicion->obs . '</td>';
			$html.= '<td><b>Respuesta</b></td>';
			$html.= '<td>' . $requerimiento_adquisicion->respuesta . '</td>';
			$html.= '</tr>';
			
			if($coctel){
				$html.= '<tr>';
				$html.= '<td><b>Dirección</b></td>';
				$html.= '<td>' . $coctel->direccion . '</td>';
				$html.= '<td><b>Fecha</b></td>';
				$html.= '<td>' . date("d/m/Y H:i", strtotime($coctel->fecha)) . '</td>';
				$html.= '</tr>';
			}

			$html.= '</table>';

			$html.= '</div>';

			$rutaPdf = "/crecic/sic/assets/files/";
			if(!file_exists($_SERVER['DOCUMENT_ROOT'].$rutaPdf))
				mkdir($_SERVER['DOCUMENT_ROOT'].$rutaPdf, 0777);
			$rutaPdf .= "pdf/";
			if(!file_exists($_SERVER['DOCUMENT_ROOT'].$rutaPdf))
				mkdir($_SERVER['DOCUMENT_ROOT'].$rutaPdf, 0777);
			
			$nombrePdf = "pdf".time().'.pdf';
			ob_start();
			$mpdf=new mPDF('utf-8','','','',0,0,0,0,6,3);
			$mpdf->SetDisplayMode('fullpage');
			$mpdf->SetTitle('Libro Clases');
			$mpdf->SetAuthor('Crecic Ltda');
			$mpdf->WriteHTML($html, 2);
			$mpdf->Output($_SERVER['DOCUMENT_ROOT'].$rutaPdf.$nombrePdf,'F');
			$rutaPdf = base_url() . "assets/files/pdf/";
			redirect($rutaPdf.$nombrePdf);
		}else{
			redirect(base_url());
		}
	}
	
}