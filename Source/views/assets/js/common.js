$(function(){
	$('.bvalidator').bValidator();; //Validate Forms			
});

 // fancybox
    $('.fancybox').click(function(){
        options = {
            'overlayOpacity'	:	0.2,
            'transitionIn'		:	'none',
            'transitionOut'		:	'none',

            onComplete : function(){
                $('input.focus, textarea.focus').focus();
            }
        };

        if ($(this).attr('width')) options.width = parseInt( $(this).attr('width') );
        if ($(this).attr('height')) options.height = parseInt( $(this).attr('height') );

        $(this).fancybox(options);
    });
//------------------------------------------  ------------------------------------------
// serializeObject
$.fn.serializeObject = function()
{
   var o = {};
   var a = this.serializeArray();
   $.each(a, function() {
	   if (o[this.name]) {
		   if (!o[this.name].push) {
			   o[this.name] = [o[this.name]];
		   }
		   o[this.name].push(this.value || '');
	   } else {
		   o[this.name] = this.value || '';
	   }
   });
   return o;
};






//------------------------------------------  ------------------------------------------
// ajax_load
function ajax_load (sender, target, callback)
{
	if (! target) target = sender;
	
	url = $(sender).attr('href');
	$.get (url, function(result)
	{
		$(target).html(result);

		if (callback) callback(result);
	});

	return false;
}






//------------------------------------------  ------------------------------------------
// ajax_call
function ajax_call (sender, callback)
{
	url = $(sender).attr('href');
	$.get (url, function(result)
	{
		if (callback) callback(result);
	});

	return false;
}






//------------------------------------------  ------------------------------------------
// ajax_call
function ajax_submit_form (form, target, callback, behavior)
{
	url = $(form).attr('action');
	post_data = $(form).serializeObject();

	$.post (url, post_data, function(result)
	{
		if (target) {
			if ( (! behavior) || (behavior == 'replace') ) $(target).html (result);
			if (behavior == 'append') $(target).append (result);
			if (behavior == 'prepend') $(target).prepend (result);
		}
		if (callback) callback(result);
	});

	return false;
}




function ajax_post_form (form,callback,wait)
{
	var url = $(form).attr('action');
	var method =$(form).attr('method');
	
	var post_data = $(form).serializeObject();
	if(wait)$(wait).show ();
	$.ajax ({
		url:url,
		type:method,
		data:post_data,
		success : function(result){
			if (callback) callback (result);
			if(wait)$(wait).hide ();
		}
	});
	
	
	return false;
}



//------------------------------------------  ------------------------------------------
/* general paging depending on paging div properties, ex: page_no="1" url="?con=movies&ajax=top_viewed&page=" */
function paging_move (container, sender, direction)
{
	// get current paging control data
	var page_no = $(sender).parent().attr('page-no');
	var page_url = $(sender).parent().attr('page-url');

	// move
	if (direction == 'next') {
		page_no++;
	} else if (direction == 'prior') {
		if (page_no <= 1) return false;
		if (page_no > 1) page_no--;
	} else {
		return false;
	}

	// get result
	var url = page_url + page_no;
	$.get(url, function(result){
		
		// if no result, then don't change current page, don't update any thing
		if ($.trim(result) == '') return false;

		// update page_no, and content
		$(sender).parent().attr('page-no', page_no);
		container.html(result);
	});
	
	// show / hide options
	//alert(page_no);
	if ( (direction == 'prior') && (page_no <= 1) ) { 
		$(sender).parent().find('.prior').hide();
		$(sender).parent().find('.next').show()

	} else {
		$(sender).parent().find('.prior').show();
		$(sender).parent().find('.next').show();
		
		var new_page_no = page_no + 1;
		var new_url = page_url + new_page_no;
		
		$.get(new_url, function(result){
			if ($.trim(result) == '') $(sender).parent().find('.next').hide();
		});
		
	}

	return false;
}




//------------------------------------------  ------------------------------------------
// more link
function paging_more (container, sender, callback)
{
	// get current paging control data
	var page_no = $(sender).attr('page-no');
	var page_url = $(sender).attr('page-url');

	// move
	page_no++;

	// show loading icon
	$(sender).addClass('loading');

	// get result
	var url = page_url + page_no;
	$.get(url, function(result){
		// if no result, then don't change current page, don't update any thing
		if ($.trim(result) == '') {
			$(sender).fadeOut('fast');
			return false;
		}

		// update page_no, and content
		$(sender).attr('page-no', page_no);
		$(container).append(result);

		$(sender).removeClass('loading');

		if (callback) callback();
	});

	return false;
}









//------------------------------------------  ------------------------------------------
function integer(expr)
{
	expr.replace("px", "");
	expr.replace(";", "");
	expr.replace("auto", "");
	expr = '0' + expr;
	return parseInt(expr, 10);
}


function isInteger (s)
{
	var i;

	if (isEmpty(s))
	if (isInteger.arguments.length == 1) return 0;
	else return (isInteger.arguments[1] == true);

	for (i = 0; i < s.length; i++)
	{
	var c = s.charAt(i);

	if (!isDigit(c)) return false;
	}

	return true;
}


function isEmpty(s)
{
	return ((s == null) || (s.length == 0))
}



function isDigit (c)
{
	return ((c >= "0") && (c <= "9"))
}





//------------------------------------------  ------------------------------------------
//Function to convert hex format to a rgb color
function rgb2hex(rgb) {
	rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
	function hex(x) {
		hexDigits = new Array("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f");
		return isNaN(x) ? "00" : hexDigits[(x - x % 16) / 16] + hexDigits[x % 16];
	}
	return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
}





//------------------------------------------  ------------------------------------------
function getSelText(input)
{
	txt = '';

	if ($.browser.msie) {
		txt = document.selection.createRange().text;
	}
	else if ($.browser.mozilla) {
		var startPos = input.selectionStart;
		var endPos = input.selectionEnd;
		txt = input.value.substring(startPos, endPos);
	}
	else if ($.browser.safari) {
		txt = document.getSelection();
	}

	return txt;
}






//------------------------------------------  ------------------------------------------
function is_email(address) 
{
	var reg = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/;
	//var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	return reg.test(address);
}






//------------------------------------------  ------------------------------------------
function fancybox (sender, iframe, onComplete, onClosed) 
{
	href = (typeof sender == 'object') ? $(sender).attr('href') : sender; 
	
	options = {
		href: href,
		'overlayOpacity'	:	0.2,
        'transitionIn'		:	'none',
        'transitionOut'		:	'none'
	};
	
	if (typeof sender == 'object') {
		if ($(sender).attr('width')) options.width = parseInt( $(sender).attr('width') );
		if ($(sender).attr('height')) options.height = parseInt( $(sender).attr('height') );
	}
	
	if (iframe) options.type = 'iframe';
	
	if (onComplete) options.onComplete = onComplete;
	if (onClosed) options.onClosed = onClosed;

	$.fancybox (options);

	return false;
}






function fancyhtml (html) 
{
	options = {
		content: html,
		'overlayOpacity'	:	0.2,
        'transitionIn'		:	'none',
        'transitionOut'		:	'none'
	};
	
	$.fancybox (options);

	return false;
}





//------------------------------------------  ------------------------------------------
function get_iframe_body (iframe) 
{
	iframe = $(iframe);
	if (! iframe) return false;
	
	return iframe.contents().find('body').html();
}






//------------------------------------------ messages ------------------------------------------
function fancy_message (message, more_class) 
{
	options = {
		'content'			: '<div class="fancy-message ' + more_class + '">' + message + '</div>',
		'overlayOpacity'	:	0.2,
        'transitionIn'		:	'none',
        'transitionOut'		:	'none'
	};
	
	$.fancybox (options);
	return false;
}




function inner_message (container, message, more_class) 
{
	html = '<div class="inner-message ' + more_class + '">' + message + '</div>';
	$(container).html(html).find('inner-message').fadeIn();
}





//------------------------------------------ title-inside ------------------------------------------
function start_title_inside (selector)
{
	if (! selector) selector = '.title-inside';

	$(selector).each(function(){
		if ($(this).attr('title')) {

			$(this).addClass('is-title').val($(this).attr('title'))
				.blur(function(){
					if ($(this).val() == '')
						$(this).addClass('is-title').val($(this).attr('title'))
				})
				.focus(function(){
					if ($(this).val() == $(this).attr('title'))
						$(this).val('').removeClass('is-title');
				});
		}
	});
}


function validate_title_inside (parent, selector)
{
	if (! selector) selector = '.title-inside';

	if (parent)
		inputs = $(parent).find (selector);
	else
		inputs = $(selector);

	var valid = true;

	inputs.each(function(){
		if ($(this).val() == $(this).attr('title')) valid = false;
	});

	return valid;
}


function ajax_get(link,data,container)
{
	$.ajax ({
			url:link,
			type:'GET',
			data:data,
			success : function (result){
				container.html(result);
			}
			});
}

// Class datepiker to make text work as date piker
function date_piker (element,date){
$(element).DatePicker({
	format:'Y-m-d',
	date: date,
	current: date,
	starts: 1,
	position: 'right',
	onChange: function(formated, dates){
		$(element).val(formated);
	}
	});
}


//------------------------------------------  ------------------------------------------














