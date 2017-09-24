<?php
class Modelo_curso extends CI_Model {
	private $tabla;
    private $prefijo;
    private $foreigns;
	
	function __construct(){
		$this->tabla = str_replace("Modelo_", "", get_class());
        $this->prefijo = $this->prefijo();
        $this->foreigns = $this->setForeigns();
		parent::__construct();
	}

	private function prefijo(){
		if(count(explode("_", $this->tabla))>1){
			return substr(explode("_", $this->tabla)[0], 0, 1) . substr(explode("_", $this->tabla)[1], 0, 1) . "_";
		}else{
			return substr($this->tabla, 0, 2) . "_";
		}
    }
    
    private function setForeigns(){
        $foreigns = array();
        return $foreigns;
    }
	
	public function getLastId(){
		$this->db->select_max("{$this->prefijo}codigo","maximo");
		$sql = $this->db->get($this->tabla);
		return $sql->row()->maximo+1;
	}
	
	public function insertar($datos){
		return $this->db->insert($this->tabla, $datos);
	}
	
	public function actualizar($datos, $where){
		$this->db->where($where);
		return $this->db->update($this->tabla, $datos);
	}

	public function eliminar($datos, $where){
		$this->db->where($where);
		return $this->db->delete($this->tabla);
	}

	public function obtener_por_codigo($codigo){
		$sql = $this->db->select('*')
				->from($this->tabla)
				->where("{$this->prefijo}codigo", $codigo)
				->limit(1)
				->get();
				
        $resultado = $sql->row();
		
        if($resultado){
			$obj = new stdClass();
			foreach(get_object_vars($resultado) as $key => $val){
				if(in_array($key, array_keys($this->foreigns))){
					$foreign = $this->foreigns[$key];
					$modelo = $this->load->model("{$foreign->dir}/modelo_{$foreign->table}");
					$obj->{$foreign->table} = $modelo->obtener_por_codigo($resultado->{$key});
				}else{
					$obj->{str_replace($this->prefijo, "", $key)} = $resultado->{$key};
				}
			}
			return $obj;
        }else{
			return false;
        }
	}
	
	public function obtener($where){
		$sql = $this->db->select('*')
				->from($this->tabla)
				->where($where)
				->limit(1)
				->get();
				
        $resultado = $sql->row();
		
        if($resultado){
			$obj = new stdClass();
			foreach(get_object_vars($resultado) as $key => $val){
				if(in_array($key, array_keys($this->foreigns))){
					$foreign = $this->foreigns[$key];
					$modelo = $this->load->model("{$foreign->dir}/modelo_{$foreign->table}");
					$obj->{$foreign->table} = $modelo->obtener_por_codigo($resultado->{$key});
				}else{
					$obj->{str_replace($this->prefijo, "", $key)} = $resultado->{$key};
				}
			}
			return $obj;
        }else{
			return false;
        }
	}
	
	public function listar($where = false, $pagina = false, $cantidad = false){

		if($pagina && $cantidad){
			$desde = ($pagina - 1) * $cantidad;
			$this->db->limit($cantidad, $desde);
		}

		if($cantidad){
			$this->db->limit($cantidad);
		}

		if($where) $this->db->where($where);
		$sql = $this->db->select('*')
				->from($this->tabla)
				->get();
        $result = $sql->result();
        if($result){
			$listado = array();
			foreach($result as $resultado){
				$obj = new stdClass();
				foreach(get_object_vars($resultado) as $key => $val){
					if(in_array($key, array_keys($this->foreigns))){
                        $foreign = $this->foreigns[$key];
                        $modelo = $this->load->model("{$foreign->dir}/modelo_{$foreign->table}");
                        $obj->{$foreign->table} = $modelo->obtener_por_codigo($resultado->{$key});
					}else{
						$obj->{str_replace($this->prefijo, "", $key)} = $resultado->{$key};
					}
				}
				$listado[] = $obj;
			}
			return $listado;
        }else {
			return false;
        }
    }
}