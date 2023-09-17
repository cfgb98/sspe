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
						<a href="#"><i class="fas fa-procedures"></i> Pacientes</a>
						<ul>
							<li><a href="lista_p.embarazadas.php"><i class="fas fa-head-side-mask"></i> Lista de Pacientes</a></li>
							<li><a href="registro_p.embarazadas.php"><i class="fas fa-clipboard-user"></i> Nueva Paciente</a></li>
						</ul>
					</li>
				<?php } ?>
				<?php 
				    if($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2 || $_SESSION['rol'] == 3 || $_SESSION['rol'] == 4){
				?>
				<li class="principal">
				    <a href="#"><i class="fas fa-heartbeat"></i> Seguimiento</a>
					<ul>
					    <li><a href="lista_seguimiento.php"><i class="fas fa-file-medical-alt"></i> Lista de Seguimiento</a></li>
						<li><a href="registro_seguimiento.php"><i class="fas fa-user-md"></i> Nuevo Seguimiento</a></li>
					</ul>
		        </li>
				<?php } ?>
				<li class="principal">
				    <a href="#"><i class="fas fa-pills"></i> Medicamentos</a>
					<ul>
					    <li><a href="lista_medicamento.php"><i class="fas fa-tablets"></i> Lista de Medicamentos</a></li>
						<li><a href="registro_medicamento.php"><i class="fas fa-syringe"></i> Nuevo Medicamento</a></li>
					</ul>
		        </li>
			</ul>
		</nav>