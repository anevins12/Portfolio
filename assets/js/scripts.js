function getFrontEndItems() {
	
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
				var span = '<img class="link" src="span-image-link-thingy.png" />';
			}

			var html = '<li>\n\
							<a class="fancybox" href="/assets/i/items/' + v.image_url + '"> ' + span + '<img src="' + v.thumb_url + '" alt="' + v.name + '"/></a> \n\
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

}
