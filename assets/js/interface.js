/*
	----------------------------------------------------------------------------------------
	Inicializacion de la aplicacion
	Location: assets/js
	----------------------------------------------------------------------------------------
*/
(function($) {
	'use strict';
	$.fn.Interface = function(method) {
		var that = this,
			methods = {
				construct: function(){
					setContainer();
					setToast();
					$('div.app-message i.close').on('click', function() {
						$(this)
							.closest('.message')
							.transition('vertical flip')
					});
					// Chequea si el usuario ingresa por primera vez e inicializa los steps
					if (First == 1) {
						_setFirstTime()
					}
				},
				public: function(){
					_scroll();
					that.find('div.accordion').accordion();
					that.Authorize('login');
					that.Authorize('register');
					that.Authorize('sendVisitorLocation');
					that.Authorize('policies');
				},
				register: function(){
					that.modalRandomPassword();
					var form = that.find('#frm-pwd');
					form.form({
						fields: PwdRules,
						inline : true,
						on: 'blur',
						onSuccess: function(){
							form.dimmer({
								closable: false,
								displayLoader: true,
								loaderVariation: 'slow green huge elastic',
								loaderText: Processing
							}).dimmer('show');
						}
					})
				},
				users: function(){
					switch(ActivePage){
						case 'home':
							that.Users('personalData')
						break;

						case 'additional-data':
							that.Users('additionalData')
						break;

						case 'password-data':
							if(DeactiveUserMsg != undefined){
								setToast(DeactiveUserMsg)
							}
							that.modalRandomPassword();
							var form = that.find('#frm-pwd');
							form.form({
								fields: Rules,
								inline : true,
								on: 'blur',
								onSuccess: function(){
									that.find('#container').dimmer({
										closable: false,
										displayLoader: true,
										loaderVariation: 'slow green huge elastic',
										loaderText: Processing
									}).dimmer('show');
								}
							})
						break;
						case 'password-reset':
							that.resetPassword()
						break;
						default:
						break;
					}
				}
			};

		methods.construct();
		if(method != undefined){
			methods[method].apply(this)
		}
		return this;

		function _scroll(){
			var nav = that.find('#public-menu');
			nav.find('a.navscroll[href^="#"]').on('click', function(event) {
				var target = $( $(this).attr('href') );
				if( target.length ) {
					event.preventDefault();
					$('html, body').animate({
						scrollTop: target.offset().top
					}, 1000);
				}
			});
		}

		function _setFirstTime(){
			that.find('div.step').removeClass('active')
			.find('i').removeClass('blue');
			that.find('div.title i').remove();
			that
				.find('#step-'+ActivePage).addClass('active')
				.find('div.title').append('&nbsp;<i class="hand point right outline icon"></i>')
				.closest('div.step').find('i').addClass('blue');
		}
	}
})(jQuery);