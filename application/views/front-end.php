
	<body class="front-end">
		
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
							<li id="front" class="selected"><a href="/">Front-end</a> <span class="pointer"></span></li>
							<li id="ux"><a href="/items/ux/">User experience</a></li>
							<li id="other"><a href="/items/other">Other stuff</a></li>
						</ul>
					</nav>
				</div>
			</header>
			
			<div id="container" class="clear">
				
				<div class="title">
					<h3>Front-end development</h3>
					<p>
						CodeIgniter and WordPress projects involved templating HTML and CSS from PSDs.
						Custom work has involved design and builds of websites.
					</p>
				</div>

				<div class="col" id="codeigniter">
					<h4>CodeIgniter</h4>
					<ul>
					</ul>
				</div>

				<div class="col" id="wordpress">
					<h4>WordPress</h4>
					<ul>
					</ul>
				</div>

				<div class="col" id="custom">
					<h4>Custom</h4>
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

			getItems('1');

			$('.fancybox').fancybox();
			
		});

		

	</script>
</html>