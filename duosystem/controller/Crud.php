<?php 

require_once 'model/DB.php';

abstract class Crud extends DB{

	protected $table;
	protected $joinS;
	protected $joinSt	;

	abstract public function insert();
	abstract public function update($id);

	public function find($id){

		$sql = "SELECT * FROM $this->table WHERE id = :id";
		$stmt = DB::prepare($sql);
		$stmt->bindParam(":id", $id);
		$stmt->execute();
		return $stmt->fetch();

	}

	public function findAll($situacao, $status){

		if(isset($situacao) && $situacao > 0){
			$filtro = " WHERE a.id_situacao = " . $situacao . "";
			if(isset($status) && $status > 0){
				$filtro = " WHERE a.id_situacao = " . $situacao . " AND a.id_status =" .$status;
			}
		}
		elseif(isset($status) && $status > 0){
			$filtro = " WHERE a.id_status = " . $status . "";
			if(isset($situacao) && $situacao > 0){
				$filtro = " WHERE a.id_status = " . $status . " AND a.id_situacao =" .$situacao;
			}
		}

		if(isset($filtro)){
			$sql = "SELECT a.*, st.nome as 'situacao', s.nome as 'status' 
	 				FROM $this->table a
	 				INNER JOIN $this->joinS s 
	  					ON a.id_status = s.id_status
	 				INNER JOIN $this->joinSt st 
	  					ON a.id_situacao = st.id_situacao". $filtro;
	  	}else{
	  		$sql = "SELECT a.*, st.nome as 'situacao', s.nome as 'status' 
	 				FROM $this->table a
	 				INNER JOIN $this->joinS s 
	  					ON a.id_status = s.id_status
	 				INNER JOIN $this->joinSt st 
	  					ON a.id_situacao = st.id_situacao";
	  	}		

		$stmt = DB::prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	public function delete($id){

		$sql = "DELETE FROM $this->table WHERE id = :id";
		$stmt = DB::prepare($sql);
		$stmt->bindParam(":id", $id);
		return $stmt->execute();
	}
}
