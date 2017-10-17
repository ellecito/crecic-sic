<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Empresas extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		if($this->session->userdata("usuario")->perfil->codigo  != 1) redirect(base_url());
		$this->layout->current = 3;
		$this->layout->subCurrent = 5;
		$this->load->model("modelo_empresa", "objEmpresa");
		$this->load->model("giros/modelo_giro", "objGiro");
		$this->load->model("rubros/modelo_rubro", "objRubro");
		$this->load->model("regiones/modelo_region", "objRegion");
		$this->load->model("comunas/modelo_comuna", "objComuna");
	}

	public function index(){
		#title
		$this->layout->title('Empresas');
		
		#metas
		$this->layout->setMeta('title','Empresas');
		$this->layout->setMeta('description','Empresas');
		$this->layout->setMeta('keywords','Empresas');

		$this->layout->js('assets/js/sistema/tabla.js');

		$contenido = [
			"empresas" => $this->objEmpresa->listar()
		];

		$this->layout->view('index', $contenido);
	}

	public function agregar(){
		if($this->input->post()){
			#validacion
			$this->form_validation->set_rules('rut', 'RUT', 'required');
			$this->form_validation->set_rules('razon_social', 'Razón Social', 'required');
			$this->form_validation->set_rules('direccion', 'Dirección', 'required');
			$this->form_validation->set_rules('contacto', 'Email', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required');
			$this->form_validation->set_rules('telefono', 'Teléfono', 'required');
			$this->form_validation->set_rules('giro', 'Giro', 'required');
			$this->form_validation->set_rules('comuna', 'Comuna', 'required');
			
			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				$error = validation_errors();
				echo json_encode(array("result"=>false,"msg"=>$error));
				exit;
			}

			if($this->objEmpresa->obtener(["em_rut" => $this->input->post("rut")])){
				echo json_encode(array("result"=>false,"msg"=>"<div>Este RUT ya esta registrado.</div>"));
				exit;
			}

			$data = [
				"em_codigo" => $this->objEmpresa->getLastId(),
				"em_rut" => $this->input->post("rut"),
				"em_razon_social" => $this->input->post("razon_social"),
				"em_direccion" => $this->input->post("direccion"),
				"em_contacto" => $this->input->post("contacto"),
				"em_email" => $this->input->post("email"),
				"em_telefono" => $this->input->post("telefono"),
				"gi_codigo" => $this->input->post("giro"),
				"ru_codigo" => $this->input->post("rubro"),
				"co_codigo" => $this->input->post("comuna")
			];

			if($this->objEmpresa->insertar($data)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"<div>Error al guardar en la base de datos.</div>"));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Empresa');
			
			#metas
			$this->layout->setMeta('title','Agregar Empresa');
			$this->layout->setMeta('description','Agregar Empresa');
			$this->layout->setMeta('keywords','Agregar Empresa');

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
				"giros" => $this->objGiro->listar(),
				"rubros" => $this->objRubro->listar(),
				"regiones" => $this->objRegion->listar(),
				"comunas" => $this->objComuna->listar()
			];

			$this->layout->view('agregar', $contenido);
		}
	}

	public function editar($codigo = false){
		if($this->input->post()){
			#validacion
			$this->form_validation->set_rules('rut', 'RUT', 'required');
			$this->form_validation->set_rules('razon_social', 'Razón Social', 'required');
			$this->form_validation->set_rules('direccion', 'Dirección', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required');
			$this->form_validation->set_rules('giro', 'Giro', 'required');
			$this->form_validation->set_rules('comuna', 'Comuna', 'required');
			
			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				$error = validation_errors();
				echo json_encode(array("result"=>false,"msg"=>$error));
				exit;
			}

			$data = [
				"em_rut" => $this->input->post("rut"),
				"em_razon_social" => $this->input->post("razon_social"),
				"em_direccion" => $this->input->post("direccion"),
				"em_contacto" => $this->input->post("contacto"),
				"em_email" => $this->input->post("email"),
				"em_telefono" => $this->input->post("telefono"),
				"gi_codigo" => $this->input->post("giro"),
				"ru_codigo" => $this->input->post("rubro"),
				"co_codigo" => $this->input->post("comuna")
			];

			if($this->objEmpresa->actualizar($data, ["em_codigo" => $this->input->post("codigo")])){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"<div>Error al actualizar la base de datos.</div>"));
				exit;
			}
		}else{
			if(!$codigo) redirect(base_url());
			#title
			$this->layout->title('Editar Empresa');
			
			#metas
			$this->layout->setMeta('title','Editar Empresa');
			$this->layout->setMeta('description','Editar Empresa');
			$this->layout->setMeta('keywords','Editar Empresa');

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

			$empresa = $this->objEmpresa->obtener_por_codigo($codigo);
			$contenido = [
				"giros" => $this->objGiro->listar(),
				"rubros" => $this->objRubro->listar(),
				"comunas" => $this->objComuna->listar(["re_codigo" => $empresa->comuna->region->codigo]),
				"regiones" => $this->objRegion->listar(),
				"empresa" => $empresa
			];

			$this->layout->view('editar', $contenido);
		}
	}

	public function excel(){

		$empresas = $this->objEmpresa->listar();
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->
			getProperties()
				->setCreator("Crecic Capacitaciones")
				->setLastModifiedBy("Crecic Capacitaciones")
				->setTitle("Mantenedor Empresas")
				->setSubject("Mantenedor Empresas")
				->setDescription("Mantenedor Empresas")
				->setKeywords("Mantenedor Empresas")
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
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Empresas');
		
		$i=3;
		$letra = 'A';
		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(35);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'RUT');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(35);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Razón Social');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(35);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Dirección');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(35);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Email');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(35);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Giro');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(35);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Rubro');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);

		foreach($empresas as $empresa){
			$i++;
			$letra = "A";

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $empresa->rut);
			$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);
				
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $empresa->razon_social);
			$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $empresa->direccion);
			$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $empresa->email);
			$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $empresa->giro->nombre);
			$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $empresa->rubro->nombre);
			$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);
		}

		$objPHPExcel->getActiveSheet()->setTitle("SIC - Empresas ".date("d-m-Y"));

		$objPHPExcel->setActiveSheetIndex(0);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="SIC_Empresas - '.date('d/m/Y').'.xls"');
		header('Cache-Control: max-age=0');
			
		$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
		$objWriter->save('php://output');
		exit;
		
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