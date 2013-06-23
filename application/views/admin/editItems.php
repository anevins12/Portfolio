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

		<div class="category">
			<h2> <?php echo $category ?> </h2>
		</div>

		<?php

			foreach ( $items as $k => $v ) {

				//Define undefined values (comes up as object in simpleXML)
				if ( is_object( $v->site_url ) ) {
					$v->site_url = '';
				}

				$featured = $v->featured;

			?>
				<div class="item">

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
					echo form_checkbox( 'featured', '' , $featured);

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

			$('form').hide();
			$('.toggle').click(function(){
				$(this).toggleClass('minimise');
				$(this).parent().toggleClass('selected');
				$(this).parent().siblings('form').slideToggle();

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

				$('[disabled]').hide();
				$('.mainCategory').change(function(){
					$('.subCat').removeAttr('disabled');
					$('.subCat').not( '#cat-' + $(this).val() ).prop('disabled',true);
					$('[disabled]').hide();
					$('select').not('[disabled]').show();
				});

			});
			



			// Only show sub-categories that belong to the parent
//			$('#subCategory').children().each(function(i,v){
//
//				if ( v.dataset.parentCategory != $('#mainCategory').find(':selected').val() ) {
//					$(this).hide();
//				}
//				else {
//					$(this).show();
//				}
//
//			});
//
//			$('#mainCategory').change(function() {
//
//				var subSelected = $(this).parent().find('#subCategory').find(':selected');
//				var mainSelected = $(this).find(':selected');
//
//				$(this).parent().find('#subCategory').children().each(function(i,v){
//
//					//Check if the current <option> in the main category <select> is a parent of the sub category <option>
//					if ( mainSelected.val() == $(v)[0].dataset.parentCategory ) {
//						$(v).show();
//					}
//					else {
//						$(v).hide();
//					}
//
//					//Trying to get rid of the selected <option> in the sub category
//					//That is no longer a child of the main category
//					if ( $(subSelected)[0].dataset.parentCategory != mainSelected.val() ) {
//
//						var oldSubCategorySelected = $(this).parent().find(':selected');
//
//						if ( mainSelected.val() != $(oldSubCategorySelected)[0].dataset.parentCategory ) {
//
//							//Add the selected attribute to the next <option> that matches the main category ID
//							$(oldSubCategorySelected).nextAll('option[data-parent-category="' + mainSelected.val() + '"]:first')
//													 .attr('selected', 'selected');
//
//							//Remove the old selected attribute
//							//$(oldSubCategorySelected).removeAttr('selected');
//							$(oldSubCategorySelected).parent().css('border', '1px solid red');
//
//							if ( $(this).parent().change() ) {
//
//							}
//
//						}
//
//						else {
//
//						}
//
//					}
//
//				});
//
//			});

			
		});

	</script>
</body>
</html>
