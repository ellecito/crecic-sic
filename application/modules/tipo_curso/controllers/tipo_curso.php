<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Tipo_curso extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		if($this->session->userdata("usuario")->perfil->codigo  != 1) redirect(base_url());
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

	public function excel(){

		$tipo_cursos = $this->objTipoCurso->listar();
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->
			getProperties()
				->setCreator("Crecic Capacitaciones")
				->setLastModifiedBy("Crecic Capacitaciones")
				->setTitle("Mantenedor Tipo Curso")
				->setSubject("Mantenedor Tipo Curso")
				->setDescription("Mantenedor Tipo Curso")
				->setKeywords("Mantenedor Tipo Curso")
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
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Tipo Curso');
		
		$i=3;
		$letra = 'A';
		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(35);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Código');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(35);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Nombre');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);

		foreach($tipo_cursos as $tipo_curso){
			$i++;
			$letra = "A";

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $tipo_curso->codigo);
			$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);
				
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $tipo_curso->nombre);
			$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);
		}

		$objPHPExcel->getActiveSheet()->setTitle("SIC - Tipo Curso ".date("d-m-Y"));

		$objPHPExcel->setActiveSheetIndex(0);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="SIC_Tipo_Curso - '.date('d/m/Y').'.xls"');
		header('Cache-Control: max-age=0');
			
		$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
		$objWriter->save('php://output');
		exit;
		
	}
	
}