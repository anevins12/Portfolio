<!DOCTYPE html>

<html>
<head>
	<title></title>
	<link href="<?php echo base_url(); ?>assets/css/jquery.fancybox.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/css/admin/style.css" rel="stylesheet" />
</head>
<body class="editItem item">

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
						Editing: <?php echo $item->name ?>
					</li>
				</ul>
			</div>

			<div class="title">
				<h1>Edit your work</h1>
				<a class="close" href="#" title="close">x</a>
				<p>
					Here you'll find a form that consists of one of your work pieces. By updating that form you are updating the information in that work piece.
				</p>
			</div>
			<?php

					//Define undefined values (comes up as object in simpleXML)
					if ( is_object( $item->site_url ) ) {
						$item->site_url = '';
					}

					// Featured is going to return an empty string or '1'

					if ( is_object( $item->featured ) ) {
						$item->featured = false;
					}
					if ( (string) $item->featured == '1' ) {
						$item->featured = true;
					}

				?>
					<div class="item">

						<h2>
							Editing: <?php echo $item->name ?>
						</h2>

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
						<?php if ( isset( $errors ) ) echo $errors; ?>

						<?php

						//get the ID
						//http://stackoverflow.com/questions/4660291/how-to-access-a-member-of-an-stdclass-in-php-that-starts-with-an
						$id = (string) $item->attributes();
						
						$hidden = array( 'id' => $id );

						echo form_open_multipart('/admin/updateItem', '', $hidden);

						$data = array(
							"name" => "title",
							"id" => "title",
							"value" => $item->name
						);

						echo form_label('Title', 'title');
						echo form_input( $data );

						$data = array(
							"name"        => "description",
							"id"          => "description",
							"value"       => $item->desc
						);

						echo form_label('Description', 'description');
						echo form_textarea( $data );

						$data = array(
							"name"        => "url",
							"id"          => "url",
							"value"       => $item->site_url
						);

						if ( isset( $item->image_url ) ) {

							echo form_label('Upload a new image', 'img');

						}
						else {

							echo form_label('Image', 'img');

						}

						?>

						<input type="file" name="img" size="20" />

						<?php

						if ( isset( $item->image_url ) ) {

						?>

						<div class="img">
							<p>Your current image &darr;</p>
							<img src="<?php echo base_url() . $item->image_url; ?>" alt="" />
						</div>

						<?php

						}

						echo form_label('Website link', 'url');
						echo form_input( $data );

						echo form_label( 'Featured', 'featured' );
						echo form_checkbox( 'featured', '' , $item->featured);

						$options = $mainCategories;

						echo form_label('Category', 'mainCategory');
						echo form_dropdown( 'mainCategory', $options, $item->cat, 'class="mainCategory"' );

						echo form_label('Sub-category', 'subCategory');


						//Have to create my own dropdown
						//Because I want to pass data attributes in the <option> elements
						?>

						<?php
						foreach ( $subCategories as $k => $val ) {

							$selected = '';

						?>

						<select class="subCat" name="subCategory" id="cat-<?php echo $k ?>">

						<?php

							foreach ( $val as $subCategory ) {

								if ( $subCategory[ 'id' ] == $item->subCat ) $selected = 'selected="selected"';

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

		</div> <!-- /container -->

		
	</div>
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/scripts.js" type="text/javascript"></script>
	<script type="text/javascript">

		jQuery(document).ready(function($){


			$('.item form').submit(function() {


				var form = $(this),
				$id			= $(form).find('input[name="id"]').val(),
				$title		= $(form).find('input[name="title"]').val(),
				$description = $(form).find('input[name="description"]').val(),
				$url         = $(form).find('input[name="url"]').val(),
				$mainCategory = $(form).find('select[name="mainCategory"]').val(),
				$subCategory  = $(form).find('select[name="subCategory"]').val();

				$.post('admin/updateItem', {
					
					id: $id,
					title: $title,
					description: $description,
					url: $url,
					mainCategory: $mainCategory,
					subCategory: $subCategory,
					json: true
					
				}, function(data) {

					console.log(data);

				});

			});

			$('.toggle').click(function(){
				
				$(this).toggleClass('minimise');

				if ( $(this).parent().parent().hasClass('item') ) {

					$(this).parent().toggleClass('selected');
					$(this).parent().siblings('form').slideToggle();

				}

				else {

					$(this).toggleClass('selected');
					var category = $(this).parents('.category');
					var categoryName = $(category).data('category');

					//Toggle siblings within the same category
					$(category).siblings( '.' + categoryName ).fadeToggle('fast');

				}
				
				return false;

			});

			$('form').each(function(){

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

		});
	</script>
</body>
</html>
