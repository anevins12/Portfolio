function getItems( category ) {
	
	var items;
	$.get("/index.php/items/getCategoryItems/" + category + "?callback=?", function(items){

		items = $.parseJSON(items);

		$.each(items, function(k,v) { 

			if (typeof(v.siteURL) == "object"){
				var span = '';
				var title = '<h4>' + v.name + '</h4>';
			}
			else { 
				var link = v.siteURL;
				var span = '<a href="' + link + '" class="link"></a>';
				var title = '<h4><a href="' + v.siteURL + '">' + v.name + '</a></h4>';
			}

			if ( v.featured == '1') {
				var featured = '<span class="featured">Final Year Project</span>';
			}
			else {
				var featured = '';
			}
console.log(v);
			var html = '<li>\n\
							' + title + '	\n\
							<a class="fancybox" href="/' + v.image_url + '"> '
								+ '<img src="' + v.thumb_url + '" alt="' + v.name + '"/>' + featured + '\n\
							</a> \n\ \n\ '
							 + span + '  \n\
							<p class="desc">' + v.desc + '</p>	\n\
						</li>';

			var hoverHtml = '<h4>' + v.name + '</h4><p>' + v.desc + '</p>';

			if (v.subCat == '4') {
				$('#codeigniter ul').append(html).hide().slideDown();
			}

			if (v.subCat == '5') {
				$('#wordpress ul').append(html).hide().slideDown();
			}

			if (v.subCat == '6') {
				$('#custom ul').append(html).hide().slideDown();
			}

			if (v.subCat == '7') {
				$('#app ul').append(html).hide().slideDown();
			}

			if (v.subCat == '8') {
				$('#software ul').append(html).hide().slideDown();
			}

			if (v.subCat == '9') {
				$('#webDesign ul').append(html).hide().slideDown();
			}

			if (v.subCat == '10') {
				$('#logo ul').append(html).hide().slideDown();
			}

			if (v.subCat == '11') {
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