
	<body class="contact about">

		<div id="wrapper">

			<header>
				<nav id="supplementary">
					<ul>
						<li><a href="/about/">About</a></li>
						<li><a href="/contact/">Contact</a></li>
					</ul>
				</nav>
				<div class="clear">
					<hgroup>
						<h1>Andrew Nevins</h1>
						<h2>Front-End Developer</h2>
					</hgroup>
					<nav id="global">
						<ul>
							<li id="front"><a href="/">Front-end</a></li>
							<li id="ux"><a href="/items/ux/">User experience</a></li>
							<li id="other"><a href="/items/other">Other stuff</a></li>
						</ul>
					</nav>
				</div>
			</header>

			<div id="container" class="clear">

				<div class="title">
					<h3>Contact</h3>
					<p>
						If you want or need to send me a message, there's a form you can fill out below that will send your message to me.
					</p>
				</div>

				<div class="col large">
					<h4>Yay! Form filling!</h4>

					<?php

					if ( !empty( $errors ) ) {

						?>
						<div class="errors">
							<h5>Hold on</h5>
							<ul>

							<?php
							foreach ( $errors as $error ) {
							?>
								<li>
								<?php echo $error; ?>
								</li>

								<?php
							}
							?>
							</ul>
						</div>
						<?php

					}
					
					if ( !$success ) {
						echo form_open('/contact/send') ;
						extract( $_POST );
						if ( !isset( $name ) ) $name = 'Your name';
						if ( !isset( $email ) ) $email = 'Your contact email';
						if ( !isset( $msg ) ) $msg = 'Your message';

						$data = array(
						  'name'        => 'name',
						  'id'          => 'name',
						  'value'       => $name,
						  'maxlength'   => '100',
						  'size'        => '50'
						);

						echo form_input($data);

						$data = array(
						  'name'        => 'email',
						  'id'          => 'email',
						  'value'       => $email,
						  'maxlength'   => '100',
						  'size'        => '100'
						);

						echo form_input($data);

						$data = array(
						  'name'        => 'msg',
						  'id'          => 'msg',
						  'value'       => $msg
						);

						echo form_textarea($data);
						echo form_submit('submit', 'Send message');

						echo form_close();
					}
					else {
						?>
					<div class="success">
						<h5>Message sent</h5>
						<p>Thanks for taking the time to message me.</p>
						<p>I may contact you promptly via email to the address you provided in the form.</p>
					</div>
						<?php
					}
					?>

				</div>
				<div class="col small">
					<h4>Whereabouts</h4>
					<img src="/assets/i/map.png" alt="Bristol" class="me" />
				</div>

			</div>

			<footer class="clear">
				<span class="border"></span>
				<hgroup>
					<h5>Andrew Nevins</h5>
					<h6>Front-End Developer</h6>
				</hgroup>
				<nav>
					<ul>
						<li class="last"><a href="/about">About</a></li>
						<li><a href="/contact">Contact</a></li>
						<li class="front-end last"><a href="/items">Front-end</a></li>
						<li><a href="/items/ux">User experience</a></li>
						<li><a href="/items/other">Other stuff</a></li>
					</ul>
				</nav>
			</footer>

		</div>

	</body>

	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>/assets/js/scripts.js"></script>
	<script>

		jQuery(document).ready(function($){
			$('form input');
			$('form input, form textarea').click(function(){
				$this = $(this);
				if ($this.val() == 'Your message' || $this.val() == 'Your contact email' || $this.val() == 'Your name') {
					$(this).val('');
					$(this).css("color", "#4F4F51");
				}
			});
		});

	</script>
</html>