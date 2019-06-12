<?php
    class data {
        public function getdatas($idrepo){
            $conn = new mysqli('localhost', 'root', '', 'repobd');

            $sql = "SELECT nombre_rep FROM repositorio WHERE id_repositorio = '$idrepo'";
            $result = $conn->query($sql);

            $row = $result->fetch_assoc();
            $data = $row["nombre_rep"];
            
            return $data;
            $conn->close();
        }
    }
?>