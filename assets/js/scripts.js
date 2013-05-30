function getItems( category ) {
	
	var items;
	$.get("/index.php/items/getCategoryItems/" + category + "?callback=?", function(items){

		items = $.parseJSON(items);

		$.each(items, function(k,v) { 

			if (typeof(v.site_url) == "object"){
				var span = '';
				var title = '<h4>' + v.name + '</h4>';
			}
			else { 
				var link = v.site_url;
				var span = '<a href="' + link + '" class="link"></a>';
				var title = '<h4><a href="' + v.site_url + '">' + v.name + '</a></h4>';
			}

			if ( v.featured != 'no') {
				var featured = '<span class="featured">Final Year Project</span>';
			}
			else {
				var featured = '';
			}

			var html = '<li>\n\
							' + title + '	\n\
							<a class="fancybox" href="/assets/i/items/' + v.image_url + '" title="' + v.name + '"> '
								+ '<img src="' + v.thumb_url + '" alt="' + v.name + '"/>' + featured + '\n\
							</a> \n\ \n\ '
							 + span + '  \n\
							<p class="desc">' + v.desc + '</p>	\n\
						</li>';

			var hoverHtml = '<h4>' + v.name + '</h4><p>' + v.desc + '</p>';

			if (v.subCat == 'CodeIgniter') {
				$('#codeigniter ul').append(html).hide().slideDown();
			}

			if (v.subCat == 'WordPress') {
				$('#wordpress ul').append(html).hide().slideDown();
			}

			if (v.subCat == 'Custom') {
				$('#custom ul').append(html).hide().slideDown();
			}

			if (v.subCat == 'App') {
				$('#app ul').append(html).hide().slideDown();
			}

			if (v.subCat == 'Software') {
				$('#software ul').append(html).hide().slideDown();
			}

			if (v.subCat == 'Web Design') {
				$('#webDesign ul').append(html).hide().slideDown();
			}

			if (v.subCat == 'Logo') {
				$('#logo ul').append(html).hide().slideDown();
			}

			if (v.subCat == 'Illustration') {
				$('#illustration ul').append(html).hide().slideDown();
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

function followElement() {

    var $sidebar   = $("#submit"),
        $window    = $(window),
        offset     = $sidebar.offset(),
        topPadding = 15;

    $window.scroll(function() {
        if ($window.scrollTop() > offset.top) {
            $sidebar.stop().animate({
                marginTop: $window.scrollTop() - offset.top + topPadding
            });
        } else {
            $sidebar.stop().animate({
                marginTop: 0
            });
        }
    });
    
}