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

			//Set out the boolean values for the checkbox
			$featured = false;
			
			if ( $v->featured == 'true' ) {
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
				"value"       => $v->site_url
			);

			echo form_label('Website link', 'url');
			echo form_input( $data );

			$options = $category;

			echo form_label('Category', 'category');
			echo form_dropdown( 'category', $options, $v->cat );

			$data = array(
				"name"        => "sub_category",
				"id"          => "sub_category",
				"value"       => $v->subCat
			);
			
			echo form_label( 'Featured', 'featured' );  
			echo form_checkbox( 'featured', '', $featured);

			echo form_label('Sub-category', 'sub_category');
			echo form_input( $data );

			echo form_submit('submit', 'Update', 'id="submit"');
			echo form_close();

		}


		?>
	</div>
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/scripts.js" type="text/javascript"></script>
	<script type="text/javascript">

	</script>
</body>
</html>
