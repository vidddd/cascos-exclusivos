<?php

require_once __DIR__ . '/config.php';
class Database{
    private $db;
    public function __construct()
    {
        $this->db = new MysqliDb (HOST,USER,PASSWORD,DATABASE);
    }

     public function insertaParticipacion($nombre, $apellidos, $email, $foto, $fbid){
        $ok = false;
        $data = Array ("fbid" => $fbid, "nombre" => $nombre,
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
      public function existeFbid($fbid) {
             $ents = $this->db->rawQueryOne('select * from participaciones where fbid=?', Array($fbid));
             if(!empty($ents)){
                 return true;
             } else {
                 return false;
             }
      }
      public function getParticipaciones($pag){
            $this->db->orderBy("id","desc");
            $this->db->page = $pag;
            // set page limit to 2 results per page. 20 by default
            $this->db->pageLimit = 6;
  $this->db->where("estado", 2);
            //  print_r($this->db->getLastQuery()); die;
             $ciudades = $this->db->paginate('participaciones', $pag);

             $ciudades[0]['total']=$this->db->totalPages;

             return $ciudades;
          }


      public function getBuscarParticipaciones($txt){
                $this->db->orderBy("id","desc");
                $this->db->where("estado", 2);
                $this->db->where('nombre LIKE ?', array("%".$txt."%"));
                $this->db->orWhere('apellidos LIKE ?', array("%".$txt."%"));
                $this->db->page = 1;
                  // set page limit to 2 results per page. 20 by default
                $this->db->pageLimit = 6;

                $ciudades = $this->db->paginate('participaciones',1);


                if($this->db->count > 0) $ciudades[0]['total']=$this->db->totalPages;
              //  print_r($this->db->getLastQuery()); die;
                 return $ciudades;
              }
}
