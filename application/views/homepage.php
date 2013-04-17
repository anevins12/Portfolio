<!DOCTYPE html>

<html>
	<head>
		<title></title>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<link href="<?php echo base_url(); ?>/assets/css/style.css" rel="stylesheet" />
		<script></script>
	</head>

	<body>

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
							<li id="front" class="selected"><a href="">Front-end</a> <span class="pointer"></span></li>
							<li id="ux"><a href="">User experience</a></li>
							<li id="other"><a href="">Other stuff</a></li>
						</ul>
					</nav>
				</div>
			</header>
			
			<div id="container" class="clear">
				
				<div class="title">
					<h3>Front-end development</h3>
					<p>
						Lorem ipsum dolor sit amet, consectetuer adipiscing elit. 
						Aenean commodo ligula eget dolor. Aenean massa. 
						Cum sociis natoque penatibus et magnis dis parturient montes, 
						nascetur ridiculus mus. 
					</p>
				</div>

				<div class="col" id="codeigniter">
					<h4>CodeIgniter</h4>
					<ul>
					</ul>
				</div>

				<div class="col" id="ux">
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

			<div id="footer">
				<hgroup>
					<h5>Andrew Nevins</h5>
					<h6>Front-End Developer</h6>
				</hgroup>
				<nav>
					<ul>
						<li><a href="">About</a></li>
						<li><a href="">Contact</a></li>
						<li><a href="">Front-end</a></li>
						<li><a href="">User experience</a></li>
						<li><a href="">Other stuff</a></li>
					</ul>
				</nav>
			</div>

		</div>

	</body>

	<script>
		
		
		jQuery(document).ready(function($) {
			var items;
			$.get("/index.php/items/getItems?callback=?", function(items){

				items = $.parseJSON(items);

				$.each(items, function(k,v) {  
					if (v.site_url.length == 0){
						var link = '';
						var span = '';
					}
					else {
						var link = v.name;
						var span = '<img class="link" src="span-image-link-thingy.png" />'
					}

					var html = '<li>\n\
									<a href="' + link + '"> ' + span + '<img src="' + v.thumb_url + '" alt="' + v.name + '"/></a> \n\
							    </li>';

					var hoverHtml = '<h4>' + v.name + '</h4><p>' + v.desc + '</p>';

					if (v.subCat == 'CodeIgniter') {
						$('#codeigniter ul').append(html);
					}

					if (v.subCat == 'UX') {
						$('#ux ul').append(html);
					}

					if (v.subCat == 'Custom') {
						$('#custom ul').append(html);
					}
				});

			});



		});

		

	</script>
</html>