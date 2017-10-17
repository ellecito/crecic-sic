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

	public function excel(){

		$usuarios = $this->objUsuario->listar();
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
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Usuarios');
		
		$i=3;
		$letra = 'A';
		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(35);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'RUT');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(35);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Nombres');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(35);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Apellido Paterno');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(35);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Apellido Materno');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(35);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Perfil');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(35);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Sucursal');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(35);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Comuna');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(35);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Estado');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(35);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Email');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);

		foreach($usuarios as $usuario){
			$i++;
			$letra = "A";

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $usuario->rut);
			$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);
				
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $usuario->nombres);
			$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $usuario->apellido_paterno);
			$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $usuario->apellido_materno);
			$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $usuario->perfil->nombre);
			$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $usuario->sucursal->nombre);
			$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $usuario->comuna->nombre);
			$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, ($usuario->estado == "t") ? "Activo" : "Inactivo");
			$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $usuario->email);
			$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);
		}

		$objPHPExcel->getActiveSheet()->setTitle("SIC - Usuarios ".date("d-m-Y"));

		$objPHPExcel->setActiveSheetIndex(0);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="SIC_Usuarios - '.date('d/m/Y').'.xls"');
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