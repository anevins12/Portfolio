function getItems( category ) {
	
	var items;
	$.get("/index.php/items/getCategoryItems/" + category + "?callback=?", function(items){

		items = $.parseJSON(items);

		$.each(items, function(k,v) {

			if (typeof(v.site_url) == "object"){
				var span = '';
			}
			else { 
				var link = v.site_url;
				var span = '<a href="' + link + '" class="link"></a>';
				
			}

			var html = '<li>\n\
							<a class="fancybox" href="/assets/i/items/' + v.image_url + '" title="' + v.name + '"> '
								+ '<img src="' + v.thumb_url + '" alt="' + v.name + '"/>\n\
							</a> \n\ \n\ '
							 + span + '  \n\
							<p class="desc">' + v.desc + '</p>	\n\
						</li>';

			var hoverHtml = '<h4>' + v.name + '</h4><p>' + v.desc + '</p>';

			if (v.subCat == 'CodeIgniter') {
				$('#codeigniter ul').append(html);
			}

			if (v.subCat == 'WordPress') {
				$('#wordpress ul').append(html);
			}

			if (v.subCat == 'Custom') {
				$('#custom ul').append(html);
			}

			if (v.subCat == 'App') {
				$('#app ul').append(html);
			}

			if (v.subCat == 'Software') {
				$('#software ul').append(html);
			}
		});

	});

}

function getFooter() {

	var supplementary = $('#supplementary ul').children();
	var global = $('#global ul').children();

	var footerMenu = new Array( supplementary, global);
	footerMenu.concat(supplementary, global);

	$.each(footerMenu, function(k,v){

			//can't get it working at the moment
			//want to generate footer menu based on header menus


	})

}