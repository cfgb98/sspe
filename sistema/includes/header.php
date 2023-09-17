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
				<?php if ($_SESSION['rol']==1){ ?>
				<img class="photouser" src="img/user.png" alt="Usuario">
				<?php
				}
				if ($_SESSION['rol']==2){?>
				<img class="photouser" src="img/med.png" alt="Usuario">
				<?php
					
				}
				if ($_SESSION['rol']==3){?>
				<img class="photouser" src="img/enf.png" alt="Usuario">
				<?php
					
				}
				?>
				<a href="salir.php"><img class="close" src="img/salir1.png" alt="Salir del sistema" title="Salir"></a>
			</div>
		</div>
	    <?php include "nav.php"; ?>
	</header>