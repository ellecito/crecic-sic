<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Cursos extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		if($this->session->userdata("usuario")->perfil->codigo  != 1) redirect(base_url());
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
			$this->form_validation->set_rules('valor', 'Valor Alumno', 'required');
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
				"cu_valor_alumno" => $this->input->post("valor"),
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
            $this->form_validation->set_rules('valor', 'Valor Alumno', 'required');
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
                "cu_valor_alumno" => $this->input->post("valor"),
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

	public function excel(){

		$cursos = $this->objCurso->listar();
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->
			getProperties()
				->setCreator("Crecic Capacitaciones")
				->setLastModifiedBy("Crecic Capacitaciones")
				->setTitle("Mantenedor Cursos")
				->setSubject("Mantenedor Cursos")
				->setDescription("Mantenedor Cursos")
				->setKeywords("Mantenedor Cursos")
				->setCategory("mantenedor");


		$styleArray = array(
				'borders' => array(
						'outline' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('argb' => '000000'),
						),
				),
				'font'    => array(
					'bold'      => true,
					'italic'    => false,
					'strike'    => false,
				),
			'alignment' => array(
					'wrap'       => true,
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'BABDBB')
			),
		);
		
		$styleArraInfo = array(
				'font'    => array(
					'bold'      => false,
					'italic'    => false,
					'strike'    => false,
					'size' => 10
					),
					'borders' => array(
						'outline' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('argb' => '000000'),
						),
				),
				'alignment' => array(
					'wrap'       => true,
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				)
		);
		
		
		$styleFont = array(
				'font'    => array(
					'bold'      => true,
					'italic'    => false,
					'strike'    => false,
				),
			'alignment' => array(
					'wrap'       => true,
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
		);

		$objPHPExcel->getActiveSheet()->getStyle('1:3')->applyFromArray($styleFont);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Cursos');
		
		$i=3;
		$letra = 'A';
		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(35);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Código');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(35);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Nombre');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(35);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Fecha Emisión');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(35);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Fecha Vencimiento');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(35);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Horas');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(35);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Alumnos');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(35);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Código');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(35);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Valor Alumno');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);

		foreach($cursos as $curso){
			$i++;
			$letra = "A";

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $curso->codigo);
			$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);
				
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $curso->nombre);
			$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);
				
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, date("d/m/Y", strtotime($curso->fecha_emision)));
			$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);
				
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, date("d/m/Y", strtotime($curso->fecha_vencimiento)));
			$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);
				
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $curso->horas);
			$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);
				
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $curso->alumnos);
			$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);
				
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $curso->sence);
			$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);
				
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $curso->valor_alumno);
			$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);
		}

		$objPHPExcel->getActiveSheet()->setTitle("SIC - Cursos ".date("d-m-Y"));

		$objPHPExcel->setActiveSheetIndex(0);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="SIC_Cursos - '.date('d/m/Y').'.xls"');
		header('Cache-Control: max-age=0');
			
		$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
		$objWriter->save('php://output');
		exit;
		
	}
	
}