
function attachLoader( obj, oid )
{
	//create an object the size of object
	loader = $(document.createElement('div'));
	//$('body').prepend(loader);
	tagName = $(obj).get(0).tagName.toLowerCase();
	insertIn = 'inside';
	if( tagName != "div" || tagName != "td" || tagName != "p" )
		insertIn = 'outside';
	if( insertIn == 'outside' )
		$('body').prepend(loader);
	else
		$(obj).prepend(loader);
	$(loader).attr('class','attachedLoader');
	if( typeof oid !== 'undefined' )
		$(loader).attr('id',oid);
	if( typeof obj === 'undefined' )
	{
		obj = window;
		w = $(obj).width();
		h = $(obj).height();
		$(loader).css('position','fixed');
	}
	else
	{
		w = $(obj).outerWidth();
		h = $(obj).outerHeight();
		o = $(obj).offset();
		if( insertIn == 'outside' )
			$(loader).css({
				top: o.top+'px',
				left: o.left+'px',
				'border-top-right-radius': $(obj).css('border-top-right-radius'),
				'border-top-left-radius': $(obj).css('border-top-left-radius'),
				'border-bottom-right-radius': $(obj).css('border-bottom-right-radius'),
				'border-bottom-left-radius': $(obj).css('border-bottom-left-radius')
			});
	}
	$(loader).css({
		width: w+'px',
		height: h+'px',
		display: 'block'
	});
	//alert($(loader).parent());
}
function destroyLoader( oid )
{
	if( typeof oid === 'undefined' )
		$('.attachedLoader').remove();
	else
		$('#'+oid+'.attachedLoader').remove();
}