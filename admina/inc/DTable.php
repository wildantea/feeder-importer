<?php
  //error_reporting(0);
  /*
 * Script:    DataTables PDO server-side script for PHP and MySQL
 * CopyLeft: 2015 - wildantea, wildantea.com
 * Email : wildannudin@gmail.com
 */
  class DTable extends Database {
    private $total_filtered;
    private $record_total;
    private $total_sukses;
    private $belum_proses;
    private $total_error;
    public $offset;
    public $data = array();
    public $request;

     function __construct($type) {
        // Let the parent handle construction. 
        parent::__construct($type); 
    }

    //filter data
    public function get_column($col) {
      foreach ($col as $key) {
        $keys=$key." LIKE ?";
        $mark[]=$keys;
      }

      $im=implode(' OR  ', $mark);
      return $im;
    }

    public function get_value($col,$value)    {
      foreach ($col as $key) {
        $val = '%'.$value.'%';
        $result[]=$val;
      }

      return $result;
    }

    //custom query datatable
    public function get_custom($sql,$columns){
      //all data request
      $requestData= $_REQUEST;
      $this->request = $requestData;

      $result = $this->pdo->prepare( $sql );
      $result->execute();
      $result->setFetchMode( PDO::FETCH_OBJ );

      if (strpos($sql,'where') !== false || strpos($sql,'WHERE') !== false) {
          $status_condition = "and";
        } else {
          $status_condition = "where";
        }

      //sukses count (status=1)
      $s_sql = $sql;
      $s_sql .= $status_condition." status_error=1";
      $sukses = $this->pdo->prepare( $s_sql );
      $sukses->execute();
      $sukses->setFetchMode( PDO::FETCH_OBJ );
      $this->total_sukses = $sukses->rowCount();

      //belum proses count (status=0)
      $b_sql = $sql;
      $b_sql .= $status_condition." status_error=0";
      $belum = $this->pdo->prepare( $b_sql );
      $belum->execute();
      $belum->setFetchMode( PDO::FETCH_OBJ );
      $this->belum_proses = $belum->rowCount();

      //error count (status=2)
      $e_sql = $sql;
      $e_sql .= $status_condition." status_error=2";
      $error = $this->pdo->prepare( $e_sql );
      $error->execute();
      $error->setFetchMode( PDO::FETCH_OBJ );
      $this->total_error = $error->rowCount();

      //save total record
      $this->record_total = $result->rowCount();
      //total filtered default

      $this->total_filtered = $result->rowCount();

      $offset = $requestData['start'];
      $offsets = $offset?$offset:0;
      $this->offset = $offsets;
      
      if( !empty($requestData['search']['value']) ) {

        if (strpos($sql,'where') !== false || strpos($sql,'WHERE') !== false) {
          $condition = "and";
        } else {
           $condition = "where";
        }

 
        $sql = $sql;
        $sql.=" $condition ".$this->get_column($columns);
        $result = $this->pdo->prepare($sql);

        //offset
        $offset = $requestData['start'];
        $offsets = $offset?$offset:0;
        $this->offset = $offsets;

        $result->execute($this->get_value($columns,$requestData['search']['value']));
        $result->setFetchMode( PDO::FETCH_OBJ );
        $this->total_filtered = $result->rowCount();

        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']." LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        
        $result = $this->pdo->prepare($sql);
        $result->execute($this->get_value($columns,$requestData['search']['value']));
        $result->setFetchMode( PDO::FETCH_OBJ );
      } else {
        //offset
        $offset = $requestData['start'];
        $offsets = $offset?$offset:0;
        $this->offset = $offsets;

        $sql = $sql;
        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        $result = $this->pdo->prepare($sql);
        $result->execute();
        $result->setFetchMode( PDO::FETCH_OBJ );
      }

      //$data = $this->table_data($result,$columns);
      //
      return $result;
    }

    public function get_offset()  {
      return $this->offset;
    }

    public function create_data(){
      $data = $this->data;
      $json_data = array(
      "draw"            => intval( $this->request['draw'] ),
      "recordsTotal"    => intval( $this->record_total ),
      "recordsFiltered" => intval( $this->total_filtered ),
      "total_sukses"    => $this->total_sukses,
      "belum_proses"    => $this->belum_proses,
      "total_errornya"  => $this->total_error,
      "data"            => $data   // total data array
      );
      echo json_encode($json_data);
      // send data as json format
    }

    public function set_data($data){
      $this->data = $data;
    }

  }

  ?>