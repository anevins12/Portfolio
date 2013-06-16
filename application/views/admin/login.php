<!DOCTYPE html>

<html>
<head>
	<title>Log in</title>
	<link href="<?php echo base_url(); ?>assets/css/jquery.fancybox.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/css/admin/style.css" rel="stylesheet" />
</head>
<body>

	<div id="wrapper">

		<h1> Log in </h1>

		<?php

			if ( isset( $errors ) ) {
		?>
			<p class="errors">
		<?php
				echo $errors;
		?>
			</p>
		<?php
			}

		?>


		<?php 
		
		echo form_open('/admin/validate', '');

		if ( !isset( $username ) ) $username = '';

		$data = array(
				"name"        => "username",
				"id"          => "username",
				"value"       => $username
			);

		echo form_label('Username', 'username');
		echo form_input( $data );

		$data = array(
				"name"        => "password",
				"id"          => "password",
				"value"       => "",
				"type"        => "password"
			);

		echo form_label('Password', 'password');
		echo form_input( $data );

		echo form_submit('submit', 'Log in', 'id="submit"');

		echo form_close();

		?>
	</div>

</body>
</html>