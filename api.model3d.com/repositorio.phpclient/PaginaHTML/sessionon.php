<?php 
	include_once('httpful/httpful.phar'); 
	
	session_start();
	$correo = $_SESSION["correo"];
	$urlDatosUsuario = "localhost/api.model3d.com/api.repositorio.com/repositorio/obtenerinfousuario/obtener_info";
	$urlRepositorios = "localhost/api.model3d.com/api.repositorio.com/repositorio/obtenerallrepos/repos_de_cuenta";

	$datosUsuario = json_encode(
		array(
			'correo'=> $correo
		)
	);

	$responseUsuario = \Httpful\Request::post($urlDatosUsuario)
		->sendsJson()
		->body($datosUsuario)
		->send();

	$id = $responseUsuario->body->usuario->id_cuenta;
	$name = $responseUsuario->body->usuario->nombre;
	$lastname = $responseUsuario->body->usuario->apellido;

	$datosRepos = json_encode(
		array(
			'id_cuenta'=> $id
		)
	);
	
	$responseRepos = \Httpful\Request::post($urlRepositorios)
		->sendsJson()
		->body($datosRepos)
		->send();


	$date = date('Y-m-d');

	//echo $responseUsuario;
	$repos =  (array) $responseRepos->body->datos;
 
	//print_r($responseRepos->body->datos);

	/*$urls = "localhost/api.model3d.com/api.repositorio.com/repositorio/obtenerallrepos/repos_de_cuenta";
	$data = array('id_cuenta' => $id);
	$options = array(
		'http' => array(
			'header'  => "Content-type: application/json",
			'method'  => 'POST',
			'content' => http_build_query($data)
		)
	);
	$context  = stream_context_create($options);
	$result = file_get_contents($urls, false, $context);
	echo $result;*/
	
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Bootstrap CRUD Data Table for Database with Modal Form</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/crudStyle.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="js/crudjs.js"></script>
</head>

<body>
	<div class="container">
		<div class="table-wrapper">
		<div class="table-title">
			<h2>Bienvenido <b><?php echo $name . " " . $lastname; ?></b></h2>
		</div>
			<div class="table-title">
				<div class="row">
					<div class="col-sm-6">
						<h2>Administra tus <b>repositorios</b></h2>
					</div>
					<div class="col-sm-12">
						<a href="#addrepomodal" class="btn btn-success" data-toggle="modal"><i
								class="material-icons">&#xE147;</i> <span>Nuevo repositorio</span></a>
						<a href="#addprojmodal" class="btn btn-success" data-toggle="modal"><i
								class="material-icons">&#xE147;</i> <span>Nuevo proyecto</span></a>
						<a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal"><i
								class="material-icons">&#xE15C;</i> <span>Eliminar</span></a>
						<a href="/api.model3d.com/repositorio.phpclient/paginahtml/logsigIN.html"
								class="btn btn-warning" data-toggle="modal"><i class="material-icons">&#xe019;</i> <span>Cerrar Sesion</span></a>
					</div>
				</div>
			</div>
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>
							<span class="custom-checkbox">
								<input type="checkbox" id="selectAll">
								<label for="selectAll"></label>
							</span>
						</th>
						<th>Id del repositorio</th>
						<th>Nombre del repositorio</th>
						<th>Fecha de cración</th>
						<th>Acciones</th>
					</tr>
                </thead>
<!--|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|-->                
		<tbody>
			<?php for($i=0; $i < count($repos); ++$i){ ?>
				<tr>
					<td>
						<span class="custom-checkbox">
							<input type="checkbox" id="checkbox1" name="options[]" value="1">
							<label for="checkbox1"></label>
						</span>
					</td>
					<td><?php echo $repos[$i]->id_repositorio; ?></td>
					<td><?php echo $repos[$i]->nombre_rep; ?></td>
					<td><?php echo $repos[$i]->fecha_ceacion; ?></td>
					<td>
						<a href="#editEmployeeModal" class="edit" data-toggle="modal"><i class="material-icons"
								data-toggle="tooltip" title="Edit">&#xE254;</i></a>
						<a href="#deleteEmployeeModal" class="delete" data-toggle="modal"><i class="material-icons"
								data-toggle="tooltip" title="Delete">&#xE872;</i></a>
					</td>
				</tr>		
			<?php } ?>	
		</tbody>
<!--|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|-->               
			</table>
			<div class="clearfix">
				<div class="hint-text">Showing <b>5</b> out of <b>25</b> entries</div>
				<ul class="pagination">
					<li class="page-item disabled"><a href="#">Previous</a></li>
					<li class="page-item"><a href="#" class="page-link">1</a></li>
					<li class="page-item"><a href="#" class="page-link">2</a></li>
					<li class="page-item active"><a href="#" class="page-link">3</a></li>
					<li class="page-item"><a href="#" class="page-link">4</a></li>
					<li class="page-item"><a href="#" class="page-link">5</a></li>
					<li class="page-item"><a href="#" class="page-link">Next</a></li>
				</ul>
			</div>
		</div>
	</div>
	<!-- Edit Modal HTML -->
<!--|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|-->
	<div id="addrepomodal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="nuevorepo.php" method="POST">
					<div class="modal-header">
						<h4 class="modal-title">Nuevo repositorio</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label>Nombre del repositorio</label>
							<input name="nombre_rep" type="text" class="form-control" required>
						</div>
						
						<div class="form-group">
							<input name="fecha_ceacion" type="hidden" class="form-control" value="<?php echo $date ?>">
							<input name="id_cuenta" type="hidden" class="form-control" value="<?php echo $id ?>">
							<input name="nombre" type="hidden" class="form-control" value="<?php echo $name ?>">
							<input name="apellido" type="hidden" class="form-control" value="<?php echo $lastname ?>">
						</div>
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-success" value="Add">
					</div>
				</form>
			</div>
		</div>
	</div>
<!--|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|1|0|-->
<!-- Edit Modal HTML -->
	<div id="editEmployeeModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form>
					<div class="modal-header">
						<h4 class="modal-title">Edit Employee</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label>Name</label>
							<input type="text" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="email" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Address</label>
							<textarea class="form-control" required></textarea>
						</div>
						<div class="form-group">
							<label>Phone</label>
							<input type="text" class="form-control" required>
						</div>
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-info" value="Save">
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Delete Modal HTML -->
	<div id="deleteEmployeeModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form>
					<div class="modal-header">
						<h4 class="modal-title">Delete Employee</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<p>Are you sure you want to delete these Records?</p>
						<p class="text-warning"><small>This action cannot be undone.</small></p>
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-danger" value="Delete">
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>