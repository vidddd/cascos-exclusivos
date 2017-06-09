<?php

require_once __DIR__ . '/config.php';
class Database{
    private $db;
    public function __construct()
    {
        $this->db = new MysqliDb (HOST,USER,PASSWORD,DATABASE);
    }
    /*
     public function insertaPersona($persona, $email, $telefono, $lugarid, $personas, $comentarios){
        $ok = false;
        $data = Array ("persona" => $persona,
                 "email" => $email,
                 "telefono" => $telefono,
                 "lugarid" => $lugarid,
                 "personas" => $personas,
                 "comentarios" => $comentarios,
                 );
          $id = $this->db->insert ('personas', $data);
          if($id){
               return $id;
          } else {
              echo 'insert failed: ' . $this->db->getLastError(); die;
          }
      }
       */
}
