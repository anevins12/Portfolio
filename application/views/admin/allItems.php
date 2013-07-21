<!DOCTYPE html>

<html>
<head>
	<title></title>
	<link href="<?php echo base_url(); ?>assets/css/jquery.fancybox.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/css/admin/style.css" rel="stylesheet" />
</head>
<body>

	<div id="wrapper">

		<header id="loggedIn" class="clearfix">
			<p>
				Logged in as
				<strong>
				<?php
						echo $loggedInUsername;
				?>
				</strong>
			</p>
			<p id="logOut">
				<a href="/admin/logout">Log out</a>
			</p>
		</header>

		<div id="container">

			<div class="breadcrumb">
				<ul>
					<li class="first last">
						Work overview
					</li>
				</ul>
			</div>
			<div class="newItem">
				<a class="gradient" href="<?php echo base_url() ?>admin/newItem">Add new work</a>
			</div>

			<div class="title">
				<h1>Overview of your work</h1>
				<a class="close" href="#" title="close">x</a>
				<p>
					On this page you can see all of your work. Click on a work piece to edit it.
				</p>
			</div>
			<?php

			foreach ( $itemsAndCategories as $category => $items ) {

			?>

			<div class="category" data-category="<?php echo $category ?>">
				<h2>
					<a href="#" class="toggle"> <?php echo $category ?>
						<span>(<?php echo count( $items ) ?>)</span>
					</a>
				</h2>

				<ul>
				<?php

					foreach ( $items as $k => $v ) { 
						$id = $v->{'@attributes'}->id;

						?>
						<li>
							<a href="<?php echo base_url() ?>admin/item/<?php echo $id ?>">
								<h3> <span><?php echo $v->name ?></span> </h3>
								<img src=" <?php echo $v->thumb_url ?> " alt="" />
							</a>
							<a href="<?php echo base_url() ?>admin/deleteItem/<?php echo $id ?>">
								Delete 
							</a>
						</li>
						<?php

					}

				?>
				</ul>

			</div>

			<?php

			}

			?>

	</div> <!-- /container -->

		
	</div>
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/scripts.js" type="text/javascript"></script>
	<script type="text/javascript">

		jQuery(document).ready(function($){

			$('.category').find('h2 a').addClass('minimised');

			$('.toggle').click(function(){
				
				$(this).toggleClass('minimised');
				$(this).parents('.category').find('ul').slideToggle('slow');
				return false;

			});

			$('.close').click(function(){
				$(this).parent().slideUp();
			});

		});
	</script>
</body>
</html>
