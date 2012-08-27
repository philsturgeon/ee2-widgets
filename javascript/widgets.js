var add_area;

function hide_add_area()
{
	$('input[name="title"]', add_area).attr('value', '');
	$('input[name="slug"]', add_area).attr('value', '');

	// Hide the form
	add_area.slideUp();

	return false;
}

function show_add_area()
{
	add_area.slideDown();
	return false;
}

$(function() {

	add_area = $('#add-area-box');

	// Widget Area add / remove --------------

	$('a#add-area').click(show_add_area);

	$('input[name=title]', add_area).keyup(function(){

		slug = $('input[name=slug]', add_area);

		if(slug.hasClass('manual')) 
		{
			return true;
		}

		slug.val( $(this).val().replace(' ', '-').replace(/[^a-z0-9\-]/ig, '').toLowerCase() );

		return true;
	});

	// Remove dodgy characters as they type into slug
	$('input[name=slug]', add_area).keyup(function(){
		$(this).val($(this).val().replace(' ', '-').replace(/[^a-z0-9\-]/ig, '')).addClass('manual');
	});

	$('form', add_area).submit(function()
	{
		title = $('input[name="title"]', this).val();
		slug = $('input[name="slug"]', this).val();

		if(!title || !slug) return false;

		$.get(WIDGET_URL + '&method=add_area&area_title=' + title + '&area_slug=' + slug, function(data) {

			data = $('.widget-area', data).html();

			$('#no-areas').hide();

			$('.widget-wrapper').append(data).children('.widget-area:hidden').slideDown('slow');

			$('#available-widgets').slideDown('slow');

			// Done, hide this form
			hide_add_area();
		});

		return false;
	});

	$('a[href=#add-area]').live('click', show_add_area);
	$('button#widget-area-cancel').live('click', hide_add_area);

	// Widget controls -----------------------

	$('.widget-area table tbody').sortable({
		handle: 'td',
		helper: function(e, ui) {
			ui.children().each(function() {
				$(this).width($(this).width());
			});
			return ui;
		},
		update: function() {
			order = new Array();
			$('tr', this).each(function(){
				order.push( this.id.replace(/^instance-/, '') );
			});
			order = order.join(',');

			$.get(WIDGET_URL + '&method=update_order', {order: order});
		}
	});

});