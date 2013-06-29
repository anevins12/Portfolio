<div class="item">

	<h3>
		<a href="#" class="toggle" id="">
			New portfolio item
		</a>
	</h3>

	<?php if ( isset( $errors ) ) echo $errors; ?>

	<?php

	echo form_open_multipart('/admin/updateItem', '', $hidden);

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
	echo form_dropdown( 'mainCategory', $options, $v->cat, 'class="mainCategory"' );

	echo form_label( 'Featured', 'featured' );
	echo form_checkbox( 'featured', '' , $v->featured);

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