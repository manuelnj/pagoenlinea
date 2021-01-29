<aside class="main-sidebar">

	<section class="sidebar">

		<ul class="sidebar-menu">

			<li>
				<a href="inicio">
					<i class="fa fa-bar-chart"></i>
					<span>INICIO</span>
				</a>
			</li>

			<?php

			$items = $_SESSION["productos"];

			foreach ($items as $producto) {
				if (is_array($producto)) {
					foreach ($producto as $value) {
						$id = $value->ProductoId;
						$nombre = $value->Descripcion;
						// $_SESSION["ultPerPago"] = $value->UltimoPeriodoPago;
						if ($id == 1) {
								
							echo '<li class="active">
									<a href="pagos?id='.$id.'">
										<i class="fa fa-file-text-o"></i>
										<span class="text-uppercase">papeleta de habilidad</span>
									</a>

								</li>';
						}

						if ($id == 3) {
							echo '<li class="active">
									<a href="pagos?id='.$id.'">
										<i class="fa fa-money"></i>
										<span class="text-uppercase">cuotas ordinarias</span>
									</a>
								</li>';
						}

						if ($id == 4) {
							echo '<li class="active">
									<a href="pagos?id='.$id.'">
										<i class="fa fa-folder-o"></i>
										<span class="text-uppercase">notificaciones jud.</span>
									</a>
								</li>';
						}
					}
				}
			}



			?>
			<li>
				<a href="salir">
					<i class="fa fa-close"></i>
					<span>SALIR</span>
				</a>
			</li>
		</ul>

	</section>

</aside>