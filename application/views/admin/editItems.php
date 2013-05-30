<!DOCTYPE html>

<html>
<head>
	<title><?php echo $title; ?></title>
	<link href="<?php echo base_url(); ?>assets/css/jquery.fancybox.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/css/admin/style.css" rel="stylesheet" />
</head>
<body>

	<div id="wrapper">
		<h1> Your portfolio items </h1>
		<?php
		
		foreach ( $items as $k => $v ) {

			//Define undefined values (comes up as object in simpleXML)
			if ( is_object( $v->site_url ) ) {
				$v->site_url = '';
			}

			$featured = false;

			if ( $v->featured != 'false') {
				$featured = true;
			}

		?>
			<h2><?php echo $v->name ?></h2>
		<?php

			$id = $v->attributes()->id;
			$hidden = array( 'id' => $id );
			
			echo form_open('/admin/updateItem', '', $hidden);
			
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
				"value"       => "http://$v->siteURL"
			);

			echo form_label('Website link', 'url');
			echo form_input( $data );

			$options = $mainCategories;

			echo form_label('Category', 'mainCategory');
			echo form_dropdown( 'mainCategory', $options, $v->cat, 'id="mainCategory"' );

			echo form_label( 'Featured', 'featured' ); 
			echo form_checkbox( 'featured', '' , $featured);

			echo form_label('Sub-category', 'subCategory');  
			
			
			//Have to create my own dropdown
			//Because I want to pass data attributes in the <option> elements
			?>
			<select name="subCategory" id="subCategory">
			<?php
			foreach ( $subCategories as $category ) {

				$selected = '';

				if ( $v->subCat == $category['id'] ) {
					$selected = 'selected="selected"';
				}

			?>
				<option value="<?php echo $category['id'] ?>" data-parent-category="<?php echo $category['parentCategory'] ?>" <?php echo $selected ?>>
					<?php echo $category['name'] ?>
				</option>
			<?php
			}
			?>
			</select>
			<?php

			echo form_submit('submit', 'Update', 'id="submit"');
			echo form_close();

		}


		?>
	</div>
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/scripts.js" type="text/javascript"></script>
	<script type="text/javascript">

		jQuery(document).ready(function($){

			var selected = $('#mainCategory').find(':selected');
			console.log(selected);
			

		});

	</script>
</body>
</html>
