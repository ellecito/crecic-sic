<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Perfiles extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		if($this->session->userdata("usuario")->perfil->codigo  != 1) redirect(base_url());
		$this->layout->current = 3;
		$this->layout->subCurrent = 2;
		$this->load->model("modelo_perfil", "objPerfil");
	}

	public function index(){
		#title
		$this->layout->title('Perfiles');
		
		#metas
		$this->layout->setMeta('title','Perfiles');
		$this->layout->setMeta('description','Perfiles');
        $this->layout->setMeta('keywords','Perfiles');
        
        $this->layout->js('assets/js/sistema/tabla.js');

		$contenido = [
			"perfiles" => $this->objPerfil->listar()
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
				"pe_codigo" => $this->objPerfil->getLastId(),
				"pe_nombre" => $this->input->post("nombre")
			];

			if($this->objPerfil->insertar($data)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"<div>Error al guardar en la base de datos.</div>"));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Perfil');
			
			#metas
			$this->layout->setMeta('title','Agregar Perfil');
			$this->layout->setMeta('description','Agregar Perfil');
			$this->layout->setMeta('keywords','Agregar Perfil');

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
				"pe_nombre" => $this->input->post("nombre")
			];

			if($this->objPerfil->actualizar($data, ["pe_codigo" => $this->input->post("codigo")])){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"<div>Error al actualizar la base de datos.</div>"));
				exit;
			}
		}else{
			if(!$codigo) redirect(base_url());
			#title
			$this->layout->title('Editar Perfil');
			
			#metas
			$this->layout->setMeta('title','Editar Perfil');
			$this->layout->setMeta('description','Editar Perfil');
			$this->layout->setMeta('keywords','Editar Perfil');

			#js
			$this->layout->js('assets/js/sistema/editar.js');
			
			$contenido = [
				"perfil" => $this->objPerfil->obtener_por_codigo($codigo)
			];

			$this->layout->view('editar', $contenido);
		}
	}

	public function excel(){

		$perfiles = $this->objPerfil->listar();
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->
			getProperties()
				->setCreator("Crecic Capacitaciones")
				->setLastModifiedBy("Crecic Capacitaciones")
				->setTitle("Mantenedor Perfiles")
				->setSubject("Mantenedor Perfiles")
				->setDescription("Mantenedor Perfiles")
				->setKeywords("Mantenedor Perfiles")
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
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Perfiles');
		
		$i=3;
		$letra = 'A';
		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(35);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Código');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(35);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Nombre');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);

		foreach($perfiles as $perfil){
			$i++;
			$letra = "A";

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $perfil->codigo);
			$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);
				
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $perfil->nombre);
			$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);
		}

		$objPHPExcel->getActiveSheet()->setTitle("SIC - Perfiles ".date("d-m-Y"));

		$objPHPExcel->setActiveSheetIndex(0);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="SIC_Perfiles - '.date('d/m/Y').'.xls"');
		header('Cache-Control: max-age=0');
			
		$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
		$objWriter->save('php://output');
		exit;
		
	}
	
}