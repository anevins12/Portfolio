
	<body class="other">

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
							<li id="ux"><a href="/items/ux">User experience</a></li>
							<li id="other" class="selected"><a href="/items/other">Other stuff</a><span class="pointer"></span></li>
						</ul>
					</nav>
				</div>
			</header>

			<div id="container" class="clear">

				<div class="title">
					<h3>Other stuff</h3>
					<p>
						Just a collection of website and logo designs, and illustrations that I've just done for fun or part of uni work.
					</p>
				</div>

				<div class="col" id="webDesign">
					<h4>Web Design</h4>
					<ul>
					</ul>
				</div>

				<div class="col" id="logo">
					<h4>Logo</h4>
					<ul>
					</ul>
				</div>

				<div class="col" id="illustration">
					<h4>Illustration</h4>
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
	<script type="text/javascript" src="<?php echo base_url()?>/assets/js/jquery.fancybox.pack.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>/assets/js/scripts.js"></script>
	<script>


		jQuery(document).ready(function($) {

			getItems('Other');
			$('.fancybox').fancybox();

		});



	</script>
</html>