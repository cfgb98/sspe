<nav>
			<ul>
				<li><a href="index.php"><i class="fa-solid fa-house"></i> Inicio</a></li>
				<?php 
				    if($_SESSION['rol'] == 1){
				?>
				<li class="principal">
					<a href="#" ><i class="fa-solid fa-users"></i> Usuarios</a>
					<ul>
					    <li><a href="lista_usuarios.php"><i class="fa-solid fa-users"></i> Lista de Usuarios</a></li>
						<li><a href="registro_usuario.php"><i class="fa-solid fa-user-plus"></i> Nuevo Usuario</a></li>
					</ul>
				</li>
				<?php } ?>
				<?php 
				    if($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2 || $_SESSION['rol'] == 3){
				?>
					<li class="principal">
						<a href="#">Pacientes</a>
						<ul>
							<li><a href="lista_p.embarazadas.php"><i class="fa-solid fa-users"></i> Lista de Pacientes</a></li>
							<li><a href="registro_p.embarazadas.php"><i class="fa-solid fa-user-plus"></i>Nueva Paciente</a></li>
						</ul>
					</li>
				<?php } ?>
				<?php 
				    if($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2 || $_SESSION['rol'] == 3 || $_SESSION['rol'] == 4){
				?>
				<li class="principal">
				    <a href="#">Seguimiento</a>
					<ul>
					    <li><a href="lista_seguimiento.php"><i class="fa-solid fa-users"></i> Lista de Seguimiento</a></li>
						<li><a href="registro_seguimiento.php"><i class="fa-solid fa-user-plus"></i>Nuevo Seguimiento</a></li>
					</ul>
		        </li>
				<?php } ?>
				<li class="principal">
				    <a href="#">Medicamentos</a>
					<ul>
					    <li><a href="lista_medicamento.php"><i class="fa-solid fa-users"></i> Lista de Medicamentos</a></li>
						<li><a href="registro_medicamento.php"><i class="fa-solid fa-user-plus"></i>Nuevo Medicamento</a></li>
					</ul>
		        </li>
			</ul>
		</nav>