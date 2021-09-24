<?php 
	include_once 'includes/init.php';
	$token = createToken();
	$_SESSION['token'] = $token;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
	<meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8" />
	<title>s7</title>
	<link rel="stylesheet" href="css/style.css">
	<script src="js/function.js"></script>
</head>
	<body>
		<h1>CRUD de Usuarios</h1>
    <p>Queda pendiente encriptar las contraseñas en la BBDD!</p>
		<?php $users = User::getAllUsers();?>
    <button id='deleteButton'>
      <div class="tooltip">  🗑️
        <span class="tooltiptext">Borrar selección</span>
      </div>
    </button>
    <button id='showPwdsButton'>  
      <div class="tooltip">  👁️
        <span class="tooltiptext">Mostrar contraseñas</span>
      </div>
    </button>
    </br>
    </br>
		<table>
			<thead id="table-head">
				<tr>
					<th>
            <input 
              type ="checkbox" 
              id   ="pickAllUsers" 
              name ="pickAllUsers" 
              value="pickAllUsers"
              > 
            </th>
					<th>Nombre </th>
					<th>Contraseña </br>encriptada </th>
					<th>Acción </th>
				</tr>
			</thead>
			<tbody id="table-body">
				<?php foreach($users as $user) :  ?>
					<tr id="<?= $user->get('id') ?>">
						<td>
              <input 
                type ="checkbox" 
                id   ="pickUser<?= $user->get('id'); ?>" 
                name ="pickUser<?= $user->get('id'); ?>" 
                value="pickUser<?= $user->get('id'); ?>"
                >               
            </td>
						<td>
              👤 <?= $user->get('name'); ?>
            </td>
						<td>
              <?= $user->get('pwd'); ?>
            </td>
						<td>	
							<button 
                data-id  ="<?= $user->get('id')  ?>"
                data-name="<?= $user->get('name')?>"
                data-pwd ="<?= $user->get('pwd') ?>"
							>
                <div class="tooltip">  ✏️
                  <span class="tooltiptext">Editar usuario</span>
                </div>
							</button>
						</td>
					</tr>
				<?php endforeach; ?>
					<tr id="add">
						<td></td>
						<td></td>
						<td></td>
						<td>	
							<button id='addButton'>
                <div class="tooltip">  ➕
                  <span class="tooltiptext">Añadir usuario</span>
                </div>
							</button>
						</td>
					</tr>
        
    
			</tbody>
		</table>


		<div id="update-user-modal" class="modal">
			<div class="modal-content">
				<span id="update-user-close-modal" class="close">&times;</span>
				<form name="updateForm">
          <pre><label for="name">Nombre</label>
<input type="text"   name="name"  value=""/>
<label for="pwd">Contraseña</label>
<input type="text"   name="pwd"   value=""/>
<input type="hidden" name="id"    value="" />
<input type="hidden" name="token" value="<?= $token ?>" />
<button type="submit">Actualizar</button>
          </pre>
				</form>
			</div>
		</div>

    <div id="add-user-modal" class="modal">
      <div class="modal-content">
        <span id="add-user-close-modal" class="close">&times;</span>
        <form name="addForm">
          <pre><label for="name">Nombre</label>
<input type="text"   name="name"  value=""/>
<label for="pwd">Contraseña</label>
<input type="text"   name="pwd"   value=""/>
<input type="hidden" name="token" value="<?= $token ?>" />
<button type="submit">Añadir</button>
          </pre>
        </form>
      </div>
    </div>

    <div id="delete-user-modal" class="modal">
      <div class="modal-content">
        <span id="delete-user-close-modal" class="close">&times;</span>
        <form name="deleteForm">
          <pre><input type="hidden" name="id"    value="" />
<input type="hidden" name="token" value="<?= $token ?>" />
<p>Confirma borrado de usuario? Esta acción es irreversible!</p>
<button type="cancel">Cancelar</button>
<button type="submit">Eliminar</button>
          </pre>
        </form>
      </div>
    </div>

		<div id="snackbar"></div>
	</body>

</html>