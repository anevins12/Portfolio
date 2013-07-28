<!DOCTYPE html>

<html>
<head>
	<title></title>
	<link href="<?php echo base_url(); ?>assets/css/jquery.fancybox.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/css/admin/style.css" rel="stylesheet" />
</head>
<body class="updateItem item">

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
					<li class="first">
						<a href="<?php echo base_url() ?>admin">
							Work overview
						</a>
					</li>
					<li class="last">
						Add new work
					</li>
				</ul>
			</div>
			
			<div class="title">
				<h1>Overview of your work</h1>
				<a class="close" href="#" title="close">x</a>
				<p>
					On this page you can see all of your work. Click on a work piece to edit it.
				</p>
			</div>

			<div class="item">
				<?php
					if ( isset( $updated ) ) {
						if ( $updated[ 'status' ] ) {
				?>

				<h3 class="message">
					<?php echo $updated[ 'message' ] ?><a href="#" class="close" title="close">x</a>
				</h3>

				<?php
						}
					}
				?>
				<h3>
					New portfolio item
				</h3>

				<?php if ( isset( $errors ) ) echo $errors; ?>

				<?php

				echo form_open_multipart('/admin/insertNewItem', '');

				$data = array(
					"name" => "title",
					"id" => "title"
				);

				echo form_label('Title', 'title');
				echo form_input( $data );

				$data = array(
					"name"        => "description",
					"id"          => "description"
				);

				echo form_label('Description', 'description');
				echo form_textarea( $data );

				$data = array(
					"name"        => "url",
					"id"          => "url"
				);

				if ( isset( $v->image_url ) ) {

					echo form_label('Upload a new image', 'img');

				}
				else {

					echo form_label('Image', 'img');

				}

				?>

				<input type="file" name="img" size="20" />

				<?php

				echo form_label('Website link', 'url');
				echo form_input( $data );

				$options = $mainCategories;

				echo form_label('Category', 'mainCategory');
				echo form_dropdown( 'mainCategory', $options, '', 'class="mainCategory"' );

				echo form_label( 'Featured', 'featured', '' );
				echo form_checkbox( 'featured', '' , '' );

				echo form_label('Sub-category', 'subCategory');


				//Have to create my own dropdown
				//Because I want to pass data attributes in the <option> elements
				?>

				<?php
				foreach ( $subCategories as $k => $v ) {

					$selected = '';

				?>

				<select class="subCat" name="subCategory" id="cat-<?php echo $k ?>">

				<?php

					foreach ( $v as $subCategory ) {
				?>
						<option value="<?php echo $subCategory['id'] ?>" <?php echo $selected ?>>
							<?php echo $subCategory['name'] ?>
						</option>
				<?php

					}

				?>

				</select>

				<?php
				}

				echo form_submit('submit', 'Update', 'id="submit"');
				echo form_close();

				?>

			</div>

		</div>

	</div>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/scripts.js" type="text/javascript"></script>
	<script>


	$('form').each(function() {

		// Get the value of the main category
		var mainCategory = $('.mainCategory').val();
		$('.mainCategory').change(function(){
			mainCategory = $(this).val();
		});

		// Get the "select" element that belongs to the selected main category element
		var subCategorySelected = $( '#cat-' + mainCategory );

		// Make all subcategory select elements disabled
		// Using the prop method instead of "attr" http://stackoverflow.com/questions/3806685/jquery-add-disabled-attribute-to-input
		$('.subCat').not( '#cat-' + mainCategory ).prop('disabled',true);

		$( '[disabled]' ).hide();
		$( '.mainCategory' ).change(function() {
			$( '.subCat' ).removeAttr( 'disabled' );
			$( '.subCat' ).not( '#cat-' + $(this).val() ).prop( 'disabled', true );
			$( '[disabled]' ).hide();
			$( 'select' ).not( '[disabled]' ).show();
		});

	});

	$('.close').click(function(){
		$(this).parent().slideUp();
	});

	</script>
	
</body>
</html>