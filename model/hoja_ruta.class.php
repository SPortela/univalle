<?php
    class hojaruta{
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
            $this->table = "hoja_ruta";


        }

        /**
        * Metodo que obtiene todos los registros de la tabla actividades.
        * @param string condicion where del query, si se requiere
        */
        public function selectAll($where = ""){
             /** Realiza el query */
                $sql = " SELECT hr.Id, hr.Registro_id, hr.Detalle, hr.Asignado_a, hr.Status, hr.Status2, hr.Created_by, hr.Created_date as fechaDetalle, rg.Nombre_completo AS contacto, us.Nombre AS Agente, st.Nombre AS Nombre_estado, st2.Nombre AS Nombre_estado2, us1.Nombre AS creado_por
                    FROM " . $this->table ." hr
					LEFT JOIN registros rg ON hr.Registro_id =  rg.Id
					LEFT JOIN usuarios us ON hr.Asignado_a = us.Cedula
					LEFT JOIN estados st ON hr.Status = st.Id
					LEFT JOIN estados st2 ON hr.Status2 = st2.Id
					LEFT JOIN usuarios us1 ON hr.Created_by = us1.Id

                    ". $where;
            //echo $sql;
            $result = $this->db->ejecutar($sql);
            if($this->db->numRows($result)){
                return $result;
            }
            else{
                return 0;
            }
        }

        public function Count($where = ""){
            $sql = " SELECT COUNT(DISTINCT id) as num FROM ". $this->table. "". $where;
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
            $sql = "SELECT  count(*) as num FROM hoja_ruta Where Id > 0";
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