/*
	----------------------------------------------------------------------------------------
	Configuracion de variables y funciones globales
	Location: assets/js
	----------------------------------------------------------------------------------------
*/
/*function initElements(){
	$('.ui.selection.dropdown').dropdown();
	$('.ui.menu .ui.dropdown').dropdown({
		on: 'hover'
	});
	$('select.dropdown').dropdown();
	$('.ui.checkbox').checkbox();
	$('[data-content]').popup();
}*/

/*function slider(){
	var mySwiper = new Swiper ('.swiper-container', {
		// Optional parameters
		direction: 'horizontal',
		speed: 1000,
		spaceBetween: 500,
		loop: true,
		autoHeight: true,
		autoplay: true
	})
}*/

function setContainer(){
	var nav = DomRootEl.find('div.app-menu'),
		container = DomRootEl.find('#container'),
		height = nav.outerHeight();
	container.css({
		'margin-top': (height + 10)+'px'
	});
}

function setToast(msg){
	var app_message = msg == undefined ? ToastMessage : msg;
	if(!$.isEmptyObject(app_message) != ''){
		DomRootEl.toast({
			title: app_message.title,
			message: app_message.message,
			class: app_message.cls,
			displayTime: app_message.duration,
			transition: {
				showMethod   : 'zoom',
				showDuration : 1000,
				hideMethod   : 'fade',
				hideDuration : 1000
			},
			compact: false,
			showProgress: 'bottom'
		});
		if(app_message.href != undefined){
			if(app_message.duration == undefined){
				location.href = BaseUrl+app_message.href
			}
			else{
				setTimeout(function(){
					location.href = BaseUrl+app_message.href
				}, app_message.duration)
			}
		}
	}
}

function copyText(idTarget) {

	/* Get the text field */
	var copy = document.getElementById(idTarget);

	/* Select the text field */
	copy.select();

	/* Copy the text inside the text field */
	document.execCommand("copy");

	/* Alert the copied text */
	//alert("Copied the text: " + copy.value);
	return copy.value
}

function copyTo(element, target){
	element.on('keyup', function(event){
		target.val(element.val())
	})
}

function validEmail(email){

}