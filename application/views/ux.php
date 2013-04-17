
	<body class="ux">

		<div id="wrapper">

			<header>
				<nav id="supplementary">
					<ul>
						<li><a href="">About</a></li>
						<li><a href="">Contact</a></li>
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
							<li id="ux" class="selected"><a href="/items/ux">User experience</a> <span class="pointer"></span></li>
							<li id="other"><a href="/items/other">Other stuff</a></li>
						</ul>
					</nav>
				</div>
			</header>

			<div id="container" class="clear">

				<div class="title">
					<h3>User experience</h3>
					<p>
						Designs of apps and software have considered the user-centred-design process throughout.
					</p>
				</div>

				<div class="col" id="app">
					<h4>App</h4>
					<ul>
					</ul>
				</div>

				<div class="col" id="software">
					<h4>Software</h4>
					<ul>
					</ul>
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
	<script type="text/javascript" src="<?php echo base_url()?>/assets/js/jquery.fancybox.pack.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>/assets/js/scripts.js"></script>
	<script>


		jQuery(document).ready(function($) {

			getItems('UX');
			$('.fancybox').fancybox();

		});



	</script>
</html>