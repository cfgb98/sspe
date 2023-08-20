<?php 

  if(empty($_SESSION['active']))
  {
    header('location: ../');
  }

?>
<header>
		<div class="header">
		    <img src="img/SEV.png" alt="" width="10%" height="150%">
			<h1></h1>
			
			<div class="optionsBar">
				<p>Guadalajara, <?php echo fecha(); ?></p>
				<span>|</span>
				<span class="user"><?php echo  $_SESSION['user'].'-'.$_SESSION['rol'] .'-'.$_SESSION['nombre'];?></span>
				<img class="photouser" src="img/user.png" alt="Usuario">
				<a href="salir.php"><img class="close" src="img/salir1.png" alt="Salir del sistema" title="Salir"></a>
			</div>
		</div>
	    <?php include "nav.php"; ?>
	</header>