<?php

require_once 'Crud.php';

class Usuarios extends Crud{

	protected $table = 'atividades';
	protected $joinSt = 'situacao';
	protected $joinS = 'status';
	
	private $nome;
	private $descricao;
	private $status;
	private $situacao;
	private $dataInicio;
	private $dataFim;


	public function setNome($nome){
		$this->nome = $nome;
	}

	public function setDescricao($descricao){
		$this->descricao = $descricao;
	}

	public function setSituacao($situacao){
		$this->situacao = $situacao;
	}

	public function setStatus($status){
		$this->status = $status;
	}

	public function setDataInicio($dataInicio){
		$this->dataInicio = $dataInicio;
	}

	public function setDataFim($dataFim){
		$this->dataFim = $dataFim;
	}

	public function insert(){
		$sql = "INSERT INTO $this->table (nome, descricao, id_situacao, id_status, data_inicio, data_fim) VALUES (:nome, :descricao, :situacao, :status, :dataInicio, :dataFim)";
		$stmt = DB::prepare($sql);
		$stmt->bindParam(":nome", $this->nome);
		$stmt->bindParam(":descricao", $this->descricao);
		$stmt->bindParam(":situacao", $this->situacao);
		$stmt->bindParam(":status", $this->status);
		$stmt->bindParam(":dataInicio", $this->dataInicio);
		$stmt->bindParam(":dataFim", $this->dataFim);
		return $stmt->execute();
	}

	public function update($id){
		$sql = "UPDATE $this->table SET nome = :nome, descricao = :descricao, id_situacao = :situacao, id_status = :status, data_inicio = :dataInicio, data_fim = :dataFim WHERE id = :id";
		$stmt = DB::prepare($sql);
		$stmt->bindParam(":id", $id);
		$stmt->bindParam(":nome", $this->nome);
		$stmt->bindParam(":descricao", $this->descricao);
		$stmt->bindParam(":situacao", $this->situacao);
		$stmt->bindParam(":status", $this->status);
		$stmt->bindParam(":dataInicio", $this->dataInicio);
		$stmt->bindParam(":dataFim", $this->dataFim);
		return $stmt->execute();
	}

	public function situacao(){

		$sql = "SELECT s.id_situacao , s.nome as situacao 
 				FROM $this->joinSt s";
		$stmt = DB::prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	public function status(){

		$sql = "SELECT s.id_status , s.nome as status 
 				FROM $this->joinS s";
		$stmt = DB::prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
	}
}