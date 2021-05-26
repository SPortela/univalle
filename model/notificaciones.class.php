<?php
	class notificacion{
		/**
		* Almacena la conexion a la base de datos
		*/
		private $db;
		/**
		* Tabla de donde se obtienen los datos
		*/
		private $table;
		/**
		* Constructor.
		* @param string db cadena de conexion de la DB
		*/

		public function __construct($db){

			$this->db = $db;
			$this->table = "notificaciones";

		}

		/**
		* Metodo que obtiene todos los registros de la tabla categorias.
		* @param string condicion where del query, si se requiere
		*/
		public function selectAll($where = ""){
			/** Realiza el query */
			$sql = "SELECT nt.Id, nt.Empresa_Id, nt.Registro_Id, nt.Fecha_Cita, nt.Status, nt.Comentario, nt.Created_date, nt.Created_by, nt.Updated_date, nt.Updated_by,
						rg.Nombre_completo AS Nombre, rg.Email AS Email,  rg.Celular AS Celular, rg.Id as IdEmp

							FROM " . $this->table . " nt
							LEFT JOIN registros rg ON rg.Id = Empresa_Id
							" . $where;
			//echo $sql;
			$result = $this->db->ejecutar($sql);
			if($this->db->numRows($result)){
				return $result;
			}
			else{
				return 0;
			}
		}
		/**
		* Metodo que obtiene todos los registros de la tabla categorias.
		* @param string condicion where del query, si se requiere
		*/
		public function Count($where=""){
			$sql = " SELECT count(*) as num FROM ". $this->table . " nt ". $where;
			//echo $sql;
			$result = $this->db->ejecutar($sql);
			if($this->db->numRows($result)){
			    return $result;
			}
			else{
			    return 0;
			}
		}


		/**
		* Metodo que obtiene todos los registros de la tabla categorias.
		* @param string condicion where del query, si se requiere
		*/
		public function selectOne(){
			/** Realiza el query */
			$sql = "SELECT Id, Nombre
					 FROM " . $this->table . " Where Status = 1";
			//echo $sql;
			$result = $this->db->ejecutar($sql);
			if($this->db->numRows($result)){
				return $result;
			}
			else{
				return 0;
			}
		}

		/**
		 * Ingresa datos a la BD
		 * @param array campos en los cuales se ingresa la informacion
		 * @param array informacion a ingresar
		 */
		public function insertData($data){
			$result = $this->db->insertData($data,$this->table);
			if($result){
				return true;
			}
			else{
				return false;
			}
		}

		/**
		 * edita datos de la BD
		 * @param array campos a editar
		 * @param array Informacion a ingresar
		 * @param string condicion where del query
		 */
		public function updateData($data,$where){
			$result = $this->db->updateData($data,$where,$this->table);
			if($result){
				return true;
			}
			else{
				return false;
			}
		}

		/**
		 * Elimina datos en la BD
		 * @param array envia todos los id que se quieren eliminar
		 */
		public function delData($idDel){
			if($this->db->deleteData($this->table,$idDel) === true){
				return true;
			}
			else{
				return false;
			}
		}
	}
?>