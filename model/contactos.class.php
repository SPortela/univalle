<?php
    class contacto{
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
            $this->table = "registros";


        }

        /**
        * Metodo que obtiene todos los registros de la tabla actividades.
        * @param string condicion where del query, si se requiere
        */
        public function selectAll($where = ""){
             /** Realiza el query */
                $sql = "SELECT rg.Id, rg.Nombre_completo,  rg.Celular, rg.Email, rg.Ciudad, rg.Tratamiento, 
                rg.Campana_Id, rg.Origen_Campana, rg.Created_date, rg.Status, rg.Status2, 
                rg.Asignado_a, rg.Fecha_asignado, st.Nombre AS Nombre_estado, st.Id AS Id_estado, 
                st.Color AS Color, st2.Nombre AS Nombre_estado2, us.Nombre AS Nombre_agente, 
                us.Usuario As Usuario_agente, us.Sede AS Sede, us2.nombre AS NombreCreador,  
                nt.Fecha_Cita, nt.Id AS IdNoti,  nt.Status AS NotiStatus, rg.Created_by
                    FROM " . $this->table ." rg
                    	LEFT JOIN estados st ON st.Id = rg.Status
                    	LEFT JOIN estados st2 ON st2.Id = rg.Status2
						LEFT JOIN usuarios us ON us.Cedula = rg.Asignado_a
                        LEFT JOIN usuarios us2 ON us2.Id = rg.Created_by
                        LEFT JOIN notificaciones nt ON nt.Empresa_Id = rg.Id
                    ". $where. "";
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
        * Metodo que obtiene todos los registros de la tabla actividades.
        * @param string condicion where del query, si se requiere
        */
        public function selectDescarga($where = ""){
             /** Realiza el query */
                $sql = "SELECT rg.Id, rg.Nombre_completo,  rg.Celular, rg.Email, rg.Tratamiento, 
                               rg.Campana_Id, rg.Origen_Campana, rg.Created_date, rg.Status, 
                               rg.Status2, rg.Asignado_a, rg.Fecha_asignado, st.Nombre AS Nombre_estado, 
                               st2.Nombre AS Nombre_estado2, 
                               (SELECT MAX(hr.Detalle) FROM hoja_ruta hr WHERE hr.Registro_id = rg.Id)  Detalle, 
                               us.Nombre AS NombreAgente, uss.Nombre NombreSede, us.Usuario As UsuarioAgente, us.Sede, rg.Ciudad
                    FROM " . $this->table ." rg
                    	LEFT JOIN estados st ON st.Id = rg.Status
                    	LEFT JOIN estados st2 ON st2.Id = rg.Status2
						LEFT JOIN usuarios us ON us.Cedula = rg.Asignado_a
                        LEFT JOIN usuarios uss ON uss.Id = us.Sede
                    ". $where. "";
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
        * Metodo que obtiene todos los registros de la tabla actividades.
        * @param string condicion where del query, si se requiere
        */
        public function selectDescargaAgencia($where = ""){
             /** Realiza el query */
                $sql = "SELECT rg.Id, rg.Nombre_completo, rg.Ciudad, rg.Celular, rg.Email, 
                        rg.Tratamiento, rg.Campana_Id, rg.Origen_Campana, rg.Created_date, 
                        rg.Status, rg.Status2, rg.Asignado_a, rg.Fecha_asignado, 
                        us.Nombre NombreAgente, us.Sede, uss.Nombre NombreSede,
                        st.Nombre AS Nombre_estado, st2.Nombre AS Nombre_estado2
                    FROM " . $this->table ." rg
                    	LEFT JOIN estados st ON st.Id = rg.Status
                    	LEFT JOIN estados st2 ON st2.Id = rg.Status2
                        LEFT JOIN usuarios us ON us.Cedula = rg.Asignado_a
                        LEFT JOIN usuarios uss ON uss.Id = us.Sede
                    ". $where. "";
            //echo $sql;
            $result = $this->db->ejecutar($sql);
            if($this->db->numRows($result)){
                return $result;
            }
            else{
                return 0;
            }
        }


        public function Count($whereC = ""){
        	$sql = " SELECT count(*) as num FROM ". $this->table. " rg

                LEFT JOIN usuarios us ON us.Cedula = rg.Asignado_a

            ". $whereC;
        	//echo $sql;
        	$result = $this->db->ejecutar($sql);
        	if($this->db->numRows($result)){
        	    return $result;
        	}
        	else{
        	    return 0;
        	}
        }
        
        
        public function CountNormal($whereC = ""){
        	$sql = " SELECT count(*) as num FROM ". $this->table. "


            ". $whereC;
        	//echo $sql;
        	$result = $this->db->ejecutar($sql);
        	if($this->db->numRows($result)){
        	    return $result;
        	}
        	else{
        	    return 0;
        	}
        }
        

        public function CountCarreras($whereC = ""){
            $sql = " SELECT tp.Tratamiento, COUNT(1) AS total FROM ". $this->table. " tp ". $whereC . " GROUP BY tp.Tratamiento
                HAVING COUNT(1) > 0 ORDER BY total DESC  LIMIT 6";
            //echo $sql;
            $result = $this->db->ejecutar($sql);
            if($this->db->numRows($result)){
                return $result;
            }
            else{
                return 0;
            }
        }


        public function UltimoId(){
            $sql = " SELECT rg.Id, rg.Tratamiento, rg.Nombre_completo,  rg.Email FROM ". $this->table. " rg ORDER BY Id DESC LIMIT 1";
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
        * Metodo que obtiene todos los registros de la tabla actividades para su paginación.
        * @param string condicion where del query, si se requiere
        */
        public function pagerCount($page){
            $sql = "SELECT  count(*) as num FROM registros Where Id > 0";
            $result = $this->db->ejecutar($sql);

            if($this->db->numRows($result)){
                $nav="";
                $dat = $this->db->datos($result);
                $pag = round((($dat['num']/$this->reg) + 0.5), 0, PHP_ROUND_HALF_UP);
                if ($pag > 0 )
        {
          $nav = "<div class=\"row\" style=\"margin-top:20px;\">
                    <div class=\"col-xs-12\">
                        <ul class=\"pagination\">";

          $i = 1;
          while($i <= $pag)
          {
            if($page == $i)
                $class = "class='active'";
            else
                $class = "";

            $nav .= "<li ".$class."><a href='registros.php?p=".$i."'><span ".$class.">".$i."</span></a></li>";
            $i++;
          }
          $nav .= "</ul>
                </div>
              </div>";
        }
                return $nav;
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
        	//print_r ($data);
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