<?php

require_once __DIR__ . '/config.php';
class Database{
    private $db;
    public function __construct()
    {
        $this->db = new MysqliDb (HOST,USER,PASSWORD,DATABASE);
    }

     public function insertaParticipacion($nombre, $apellidos, $email, $foto){
        $ok = false;
        $data = Array ("nombre" => $nombre,
                 "apellidos" => $apellidos,
                 "email" => $email,
                 "foto" => $foto
                 );
          $id = $this->db->insert ('participaciones', $data);
          if($id){
               return $id;
          } else {
              echo 'insert failed: ' . $this->db->getLastError(); die;
          }
      }
      
      public function existeEmail($email) {
             $ents = $this->db->rawQueryOne('select * from participaciones where email=?', Array($email));
             if(!empty($ents)){
                 return true;
             } else {
                 return false;
             }
      }
}
