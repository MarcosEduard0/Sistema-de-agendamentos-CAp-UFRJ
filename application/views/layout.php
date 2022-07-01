<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
	<meta name="author" content="Marcos Eduardo">
	<title><?= html_escape($title) ?> | Lab. Informática</title>
	<?php
	foreach ($styles as $style) {
		$url = sprintf('%s', base_url($style));
		echo "<link media='screen' rel='stylesheet' href='{$url}'>";
	}
	?>
	<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets/brand/favicon-32x32.png') ?>">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/brand/favicon-16x16.png') ?>">


</head>

<body>
	<?php
	if ($this->userauth->logged_in()) : {
			$menu[0]['class'] = 'fa fa-book';
			$menu[0]['href'] = site_url('bookings');
			$menu[0]['title'] = 'Agendamentos';

			$menu[1]['class'] = 'fa fa-home';
			$menu[1]['href'] = site_url('/');
			$menu[1]['title'] = 'Início';

			$menu[2]['href'] = site_url('profile/edit');
			$menu[2]['title'] = 'Perfil';

			$menu[3]['class'] = 'fa fa-user';
			$menu[3]['href'] = site_url('logout');
			$menu[3]['title'] = 'Sair';
		}
	?>
		<!-- Navbar -->
		<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
			<div class="container">
				<?php
				$name = '';
				$name = setting('name');
				if (config_item('is_installed')) {
					$name = setting('name');
				}
				if (strlen($name)) {
					echo anchor('/', html_escape($name), 'class="navbar-layout text-white"');
				} else {
					$attrs = "title='CAp UFRJ' style='font-weight:normal;color:#0081C2;letter-spacing:-2px'";
					$output = "CAp UFRJ ";
					$output .= "<span style='color:#ff6400;font-weight:bold'>Sistema de Agendamentos</span>";
					echo anchor('/', $output, $attrs, 'class="navbar-layout text-white"');
				}
				?>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarsExampleDefault">
					<ul class="navbar-nav ml-auto">
						<!-- Opções da NavBar -->
						<?php if (isset($menu)) : ?>
							<!-- Inicio -->
							<li class="nav-item">
								<a class="nav-link" href="<?php echo $menu[1]['href'] ?>" title="<?php echo $menu[1]['title'] ?>"><i class="<?php echo $menu[1]['class'] ?>"></i> <?php echo $menu[1]['title'] ?></a>
							</li>&nbsp&nbsp
							<!-- Agendamentos -->
							<li class="nav-item">
								<a class="nav-link" href="<?php echo $menu[0]['href'] ?>" title="<?php echo $menu[0]['title'] ?> "><i class="<?php echo $menu[0]['class'] ?>"></i> <?php echo $menu[0]['title'] ?></a>
							</li>&nbsp&nbsp
						<?php endif; ?>
						<!-- Começo do Dropdown Perfil / Logout  -->
						<?php if ($this->userauth->logged_in()) :
							$output = html_escape(strlen($this->userauth->user->displayname) > 1 ? $this->userauth->user->displayname : $this->userauth->user->firstname);
						?>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="<?php echo $menu[3]['class'] ?>"></i>&nbsp<?php echo $output ?>&nbsp</a>
								<div class="dropdown-menu">
									<a class="dropdown-item" href="<?php echo $menu[2]['href'] ?>"><i class="fa fa-pencil fa-fw"></i> <?php echo $menu[2]['title'] ?></a>
									<a class="dropdown-item" href="<?php echo $menu[3]['href'] ?>"><i class="fa fa-sign-out"></i> <?php echo $menu[3]['title'] ?></a>
								</div>
							</li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
		</nav>
	<?php endif ?>
	<!-- Mensagem de manutenção em todo site -->
	<?php
	if (setting('maintenance_mode') == 1) {
		$message = setting('maintenance_mode_message');
		if (!strlen($message)) {
			$message = 'O sistema de agendamento está em manutenção. Por favor volte mais tarde.';
		}
		echo "<div class='maintenance-wrapper'>";
		echo "<div class='outer-maintenance'>";
		echo html_escape($message);
		echo "</div>";
		echo "</div>";
	}
	?>

	<?php
	if ($this->userauth->logged_in()) : ?>
		<div class="outer">
			<?php if (isset($midsection)) : ?>
				<div class="mid-section" align="center">
					<h1 style="font-weight:normal"><?php echo $midsection ?></h1>
				</div>
			<?php endif; ?>
			<!-- Titulo e Corpo das outras Views -->
			<div class="content_area">
				<?php if (isset($showtitle)) {
					echo '<h2>' . html_escape($showtitle) . '</h2>';
				} ?>
				<?php echo $body ?>
			</div>
			<!-- Rodapé -->
			<div class="footer">
				<br />
				<div id="footer">
					<br />
					<small class="form-text text-muted">
						Adptado de <a href="https://www.classroombookings.com/" target="_blank">classroombookings</a> por
						<t up-tooltip="marcos.eduardo22@gmail.com">Marcos Eduardo de Souza</t>.
						<br />Versão <?= VERSION ?>&copy; <?= date('Y') ?>
					</small>
					<br /><br />
				</div>
			</div>
		</div>
	<?php else :
		echo $body; ?>
		<div id="tipDiv" style="position:absolute; visibility:hidden; z-index:100"></div>
	<?php endif ?>


	<!-- <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script> -->
	<!-- <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js'></script> -->
	<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
	<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script> -->
	<!-- <script type='text/javascript' src="https://code.jquery.com/jquery-3.5.1.js"></script> -->

	<?php
	foreach ($scripts as $script) {
		// $url = sprintf('%s?v=%s', base_url($script), VERSION);
		$url = base_url($script);
		echo "<script type='text/javascript' src='{$url}'></script>\n";
	} ?>
	<script>
		var h = document.getElementsByTagName("html")[0];
		(h ? h.classList.add('js') : h.className += ' ' + 'js');
		var BASE_URL = "<?= base_url() ?>";
	</script>
</body>

</html>