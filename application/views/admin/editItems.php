<!DOCTYPE html>

<html>
<head>
	<title></title>
	<link href="<?php echo base_url(); ?>assets/css/jquery.fancybox.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/css/admin/style.css" rel="stylesheet" />
</head>
<body>

	<div id="wrapper">
		<h1> Your portfolio items </h1>
		<p id="loggedIn">
			Logged in as
			<strong>
		<?php
				echo $loggedInUsername;
		?>.
			</strong>
		</p>
		<p id="logOut">
			<a href="/admin/logout">Log out.</a>
		</p>

		<?php
		
		foreach ( $itemsAndCategories as $category => $items ) {

		?>

		<div class="category" data-category="<?php echo $category ?>">
			<h2> <a href="#" class="toggle"> <?php echo $category ?><span>(<?php echo count( $items ) ?>)</span> </a> </h2>
		</div>

		<?php

			foreach ( $items as $k => $v ) {

				//Define undefined values (comes up as object in simpleXML)
				if ( is_object( $v->site_url ) ) {
					$v->site_url = '';
				}

				// Featured is going to return an empty string or '1'

				if ( is_object( $v->featured ) ) {
					$v->featured = false;
				}
				if ( (string) $v->featured == '1' ) {
					$v->featured = true;
				}

			?>
				<div class="item <?php echo $category ?>">

					<h3>
						<a href="#" class="toggle" id="<?php echo $v->name ?>">
							<?php echo $v->name ?>
						</a>
					</h3>

					<?php if ( isset( $errors ) ) echo $errors; ?>

					<?php

					//get the ID
					//http://stackoverflow.com/questions/4660291/how-to-access-a-member-of-an-stdclass-in-php-that-starts-with-an
					$id = $v->{'@attributes'}->id;
					$hidden = array( 'id' => $id );

					echo form_open_multipart('/admin/updateItem', '', $hidden);

					$data = array(
						"name" => "title",
						"id" => "title",
						"value" => $v->name
					);

					echo form_label('Title', 'title');
					echo form_input( $data );

					$data = array(
						"name"        => "description",
						"id"          => "description",
						"value"       => $v->desc
					);

					echo form_label('Description', 'description');
					echo form_textarea( $data );

					$data = array(
						"name"        => "url",
						"id"          => "url",
						"value"       => $v->site_url
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

					if ( isset( $v->image_url ) ) {

					?>

					<div class="img">
						<p>Your current image &darr;</p>
						<img src="<?php echo base_url() . $v->image_url; ?>" alt="" />
					</div>

					<?php

					}

					echo form_label('Website link', 'url');
					echo form_input( $data );

					$options = $mainCategories;

					echo form_label('Category', 'mainCategory');
					echo form_dropdown( 'mainCategory', $options, $v->cat, 'class="mainCategory"' );

					echo form_label( 'Featured', 'featured' );
					echo form_checkbox( 'featured', '' , $v->featured);

					echo form_label('Sub-category', 'subCategory');


					//Have to create my own dropdown
					//Because I want to pass data attributes in the <option> elements
					?>
<!--					-->
					<?php 
					foreach ( $subCategories as $k => $v ) {

						$selected = '';
					?>

					<select class="subCat" name="subCategory" id="cat-<?php echo $k ?>">

					<?php
//						if ( $v->subCat == $v[ $k ][ 'id' ] ) {
//							$selected = 'selected="selected"';
//						}

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
		
			<?php
			}

		}

		?>

		
	</div>
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/scripts.js" type="text/javascript"></script>
	<script type="text/javascript">

		jQuery(document).ready(function($){

			$('form, .item').hide();
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

		});
	</script>
</body>
</html>
