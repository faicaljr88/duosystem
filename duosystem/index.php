<?php
	error_reporting(0);
	spl_autoload_register(function($class_name){
		require_once 'controller/' . $class_name . '.php';
	});
?>
<!DOCTYPE HTML>
<html land="pt-BR">
<head>
   <title>PHP OO - Atividades</title>
<meta name="description" content="PHP OO" />
<meta name="robots" content="index, follow" />
<meta charset="UTF-8"/>
<link rel="stylesheet" href="assets/css/bootstrap.css" />
<link rel="stylesheet" />
  <!--[if lt IE 9]>
      <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
   <![endif]-->
</head>
<body>
	<div class="container">
	<?php

	$usuario = new Usuarios();

	if(isset($_POST['cadastrar'])){
		$nome = $_POST['nome'];
		$descricao = $_POST['descricao'];
		$situacao = (int)$_POST['situacao'];
		$status = (int)$_POST['status'];
		$dataInicio = $_POST['dataInicio'];
		$dataFim = $_POST['dataFim'];

		$usuario->setNome($nome);
		$usuario->setdescricao($descricao);
		$usuario->setSituacao($situacao);
		$usuario->setStatus($status);
		$usuario->setDataInicio($dataInicio);
		$usuario->setDataFim($dataFim);
		$usuario->insert();

	}

	?>
	<header class="masthead">
			<h1 class="muted">Listagem das Atividades</h1>
			<nav class="navbar">
				<div class="navbar-inner">
					<div class="container">
						<ul class="nav">
							<li><a href="index.php">Página inicial</a></li>
						</ul>
					</div>
				</div>
			</nav>
	</header>
	
	<table class="table">
		<thead>
			<tr>
				<th class="col-md-1">Nome:</th>
				<th class="col-sm-1">Descrição:</th>
				<th class="col-md-9">Status:</th>
				<th>Situacao:</th>
				<th>Data Inicio:</th>
				<th>Data Fim:</th>
				<th>Ações:</th>
			</tr>
		</thead>
		<?php 
		if(isset($_POST['buscar'])){

			$situacao_b = isset($_POST['situacao_b'])?$_POST['situacao_b']:1;
			$status_b = $_POST['status_b'];
		}

		foreach($usuario->findAll($situacao_b, $status_b) as $key => $value){ ?>
		<tbody>
			<?php 
				echo ($value->id_status == 1)? "<tr class='success'>":"<tr>";
			?>
				<td class="col-md-1"	><?php echo $value->nome; ?></td>
				<td><?php echo $value->descricao; ?></td>
				<td><?php echo $value->situacao; ?></td>
				<td><?php echo $value->status; ?></td>
				<td><?php echo date("d/m/Y", strtotime($value->data_inicio)) ?></td>
				<td><?php echo date("d/m/Y", strtotime($value->data_fim)) ?></td>
			<?php 
				if($value->id_status != 1){
				
			?>
				<td><?php echo "<a href='index.php?acao=editar&id=". $value->id ."' class='btn btn-warning'> Editar</a>"; ?> - 
					<?php echo "<a href='index.php?acao=deletar&id=". $value->id ."' onclick='return confirm(\"Gostaria de deletar a atividade ". $value->nome ."?\");' class='btn btn-danger'> Deletar</a>"; ?>
				</td>
			<?php }else{?>
				<td>
					<?php echo "<a href='index.php?acao=deletar&id=". $value->id ."' onclick='return confirm(\"Gostaria de deletar o Usuário ". $value->nome ."?\");' class='btn btn-danger'> Deletar</a>"; ?>	
				</td>
			
			</tr>
		</tbody>
		<?php }} ?>
	</table>
	<?php
	if(isset($_POST['atualizar'])){
		$id = $_POST['id'];
		$nome = $_POST['nome'];
		$descricao = $_POST['descricao'];
		$situacao = (int)$_POST['situacao'];
		$status = (int)$_POST['status'];
		$dataInicio = $_POST['dataInicio'];
		$dataFim = $_POST['dataFim'];


		$usuario->setNome($nome);
		$usuario->setdescricao($descricao);
		$usuario->setSituacao($situacao);
		$usuario->setStatus($status);
		$usuario->setDataInicio($dataInicio);
		$usuario->setDataFim($dataFim);
		$usuario->update($id);

		header("Location: index.php");
	}

	if(isset($_GET['acao']) && $_GET['acao'] == 'deletar'){
		$id = (int)$_GET['id'];

		$usuario->delete($id);
		header("Location: index.php");
	}

	?>

	<?php 
	if(isset($_GET['acao']) && $_GET['acao'] == 'editar'){
		$id = (int)$_GET['id'];
		$resultado = $usuario->find($id);
	?>
	
		<form method="post" action="">
			<input type="hidden" name="id" value="<?php echo $resultado->id; ?>"/>
			<div class="form-group">
				<span class="add-on"><i class="icon-pencil"></i></span>
				<input type="text" name="nome" value="<?php echo $resultado->nome; ?>" required/>
			</div>
			<div class="form-group">
				<span class="add-on"><i class="icon-comment"></i></span>
				<textarea name="descricao" required/><?php echo $resultado->descricao; ?></textarea>
			</div>
			<div class="form-group">
				<span class="add-on"><i class="icon-flag"></i></span>
				<select name="situacao">
				<?php foreach($usuario->situacao() as $key => $value){ ?>
				  	<option value="<?php echo $value->id_situacao; ?>">
	    				<?php echo $value->situacao; ?>
					</option>
				<?php } ?>
				</select>
			</div>
			<div class="form-group">
				<span class="add-on"><i class="icon-ok"></i></span>
				<select name="status">
				<?php foreach($usuario->status() as $key => $value){ ?>
				  	<option value="<?php echo $value->id_status; ?>">
	    				<?php echo $value->status; ?>
					</option>
				<?php } ?>
				</select>
			</div>
			<div class="form-group">
				<span class="add-on"><i class="icon-calendar"></i></span>
				<input type="date" name="dataInicio" value="<?php echo $resultado->data_inicio; ?>" required/>
			</div>
			<div class="form-group">
				<span class="add-on"><i class="icon-calendar"></i></span>
				<input type="date" name="dataFim" value="<?php echo $resultado->data_fim; ?>" required/>
			</div>
			<br />
				<input type="submit" name="atualizar" class="btn btn-success" value="Atualizar dados">
				<a href="index.php" class="btn btn-danger">Cancelar</a>					
		</form>

	<?php }else{ ?>
		<form method="post">
		<div class="form-group">
		    <div class="input-prepend">
				<span class="add-on"><i class="icon-search"></i></span>
				<select class="selectpicker" name="situacao_b">
					<option value = "0">Filtrar por Situação</option>
				<?php foreach($usuario->situacao() as $key => $value){ ?>
				  	<option value="<?php echo $value->id_situacao; ?>">
						<?php echo $value->situacao; ?>
					</option>
				<?php } ?>
				</select>
			</div>
			<div class="input-prepend">
				<span class="add-on"><i class="icon-search"></i></span>
				<select class="selectpicker" name="status_b">
					<option value = "0">Filtrar por Status</option>
				<?php foreach($usuario->status() as $key => $value){ ?>
				  	<option value="<?php echo $value->id_status; ?>">
						<?php echo $value->status; ?>
					</option>
				<?php } ?>
				</select>
			</div>
			<div class="input-prepend">
	    		<input type="submit" name="buscar" value="Buscar" class='btn btn-default'/>
    		</div>
		</div>
	</form>

	<form method="post" action="">
	<div class="container full-height">
		<h3 class="muted">Cadastrar Atividade</h3>
			<div class="form-group">
				<span class="add-on"><i class="icon-pencil"></i></span>
				<input type="text" name="nome" class="form-control" placeholder="Nome:" required/>
			</div>
			<div class="form-group">
				<span class="add-on"><i class="icon-comment"></i></span>
				<textarea name="descricao" class="form-control" placeholder="Descrição:" required/></textarea>
			</div>
			<div class="form-group">
				<span class="add-on"><i class="icon-flag"></i></span>
				<select name="situacao" class="form-control">
				<?php foreach($usuario->situacao() as $key => $value){ ?>
				  	<option value="<?php echo $value->id_situacao; ?>">
	    				<?php echo $value->situacao; ?>
					</option>
				<?php } ?>
				</select>
			</div>
			<div class="form-group">
				<span class="add-on"><i class="icon-ok"></i></span>
				<select name="status" class="form-control">
				<?php foreach($usuario->status() as $key => $value){ ?>
				  	<option value="<?php echo $value->id_status; ?>">
	    				<?php echo $value->status; ?>
					</option>
				<?php } ?>
				</select>
			</div>
			<div class="form-group">
				<span class="add-on"><i class="icon-calendar"></i></span>
				<input type="date" title="Data de Inicio" name="dataInicio" class="form-control" required/>
			</div>
			<div class="form-group">
				<span class="add-on"><i class="icon-calendar"></i></span>
				<input type="date" title="Data de Encerramento" name="dataFim" class="form-control" required/>
			</div>
			<div class="form-group">
				<input type="submit" name="cadastrar" class="btn btn-success" value="Cadastrar dados">		
			</div>
		</div>			
	</form>
	<?php } ?>
	<script src="assets/js/jQuery.js"></script>
	<script src="assets/js/bootstrap.js"></script>
</body>
</html>