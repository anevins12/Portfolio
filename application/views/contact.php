
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
						<div class="errprs"
							<h5>Hang on</h5>
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
					
					echo form_open('/contact/send') ;

					$data = array(
					  'name'        => 'name',
					  'id'          => 'name',
					  'value'       => 'Your name',
					  'maxlength'   => '100',
					  'size'        => '50',
					  'style'       => 'width: 99.5%',
					);

					echo form_input($data);

					$data = array(
					  'name'        => 'email',
					  'id'          => 'email',
					  'value'       => 'Your contact email',
					  'maxlength'   => '100',
					  'size'        => '100',
					  'style'       => 'width: 99.5%',
					);

					echo form_input($data);

					$data = array(
					  'name'        => 'msg',
					  'id'          => 'msg',
					  'value'       => 'Your message',
					  'style'       => 'width: 99.5%', 'height: 300px'
					);

					echo form_textarea($data);
					echo form_submit('submit', 'Send message');

					echo form_close();
					?>

				</div>
				<div class="col small">
					<h4>Whereabouts</h4>
					<img src="/assets/i/map.png" alt="Bristol" class="me" />
				</div>

				<div class="hobbies">
					<h5>What I like to do</h5>
					<div class="col">
						<h6>Take pictures of stuff</h6>
						<p>
							Yeah, I'm not a photographer but just another fan of Instagram.
						</p>
						<p>
							I did however like taking photos of stuff before Instagram came out ;)
						</p>
						<h6><a href="http://web.stagram.com/n/andrewn12/">My Instagram Feed</a></h6>
					</div>

					<div class="col">
						<h6>Swim</h6>
						<p>
							After training for a swimming test for a canoe club,
							I've discovered how great swimming is! No, really, I'm serious, but not really.
						</p>
						<p>
							I'm not competitive, but I find swimming really helps relieve stress.
						</p>
					</div>

					<div class="col">
						<h6>Help WordPress</h6>
						<p>
							9 months ago I needed some help on WordPress.org's forums.
							I didn't get an answer, but I found I could answer other people. Great!
							I felt useful.
						</p>
						<p>
							Ever since then, I've been helping people out with basic WordPress stuff, but mainly it's CSS and HTML support.
						</p>
						<p>
							I've even been given an Administrator account :)
						</p>
						<h6><a href="http://wordpress.org/support/profile/anevins">My WordPress profile</a></h6>
					</div>

					<div class="col">
						<h6>Other</h6>
						<p>
							I do have other hobbies, but I think I'll be going OTT with this page if I say them all.
						</p>
					</div>
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
						<li class="last"><a href="">About</a></li>
						<li><a href="">Contact</a></li>
						<li class="front-end last"><a href="">Front-end</a></li>
						<li><a href="">User experience</a></li>
						<li><a href="">Other stuff</a></li>
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
				}
			});
			$('form').submit(function() {
				console.log(this);
				if ($this.val() == 'Your message' || $this.val() == 'Your contact email' || $this.val() == 'Your name') {
					$(this).val('');
				}
			})
		});

	</script>
</html>