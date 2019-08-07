/*
	----------------------------------------------------------------------------------------
	Autenticacion de usuarios
	Location: assets/js
	----------------------------------------------------------------------------------------
*/
(function($) {
	'use strict';
	$.fn.Authorize = function(method) {
		var that = this,
			methods = {
				login: function(){
					var nav = that.find('#public-menu'),
						popUp = nav.find('#menu-login');
					popUp.popup({
						popup: that.find('#login-form'),
						inline: true,
						on: 'click',
						position: 'bottom right',
						delay: {
							show: 300,
							hide: 800
						},
						onShow: function(){
							$(this).find('#btn-fpwd').on('click', function(e){
								e.stopImmediatePropagation();
								popUp.popup('hide')
								_showForgotPassword()
							})
						}
					});
					that.find('#frm-login').form({
						fields: LoginRules,
						inline : true,
						on: 'blur',
						onSuccess: function(){
							modal.dimmer({
								closable: false,
								displayLoader: true,
								loaderVariation: 'slow green huge elastic',
								loaderText: Processing
							}).dimmer('show');
						}
					})
				},
				register: function(){
					var form = that.find('#frm-register'),
						btnResume = that.find('#btn-show-resume');
					form.find('select.dropdown').dropdown();
					btnResume.on('click', function(e){
						form.form({
							fields: RegisterRules,
							inline : true,
							on: 'blur'
						})
						if(form.form('is valid')){
							_showRegisterResume(form);
						}
					})
				},
				sendVisitorLocation: function(){
					that.Location({}, 'geolocation').then(
						function(latlng){
							if(latlng.lat != undefined){
								that.Address({
									location: latlng
								}, 'get')
								.then(
									function(response){
										that.Location({location: latlng}, 'timezone').then(
											function(tz){
												$.fn.request({
													url: BaseUrl+'index.php/setnewvisitor',
													type: 'GET',
													data: {
														address: response.formatted_address,
														country: response.country.short_name,
														timezone: JSON.stringify(tz)
													}
												})
											}
										)
									}
								)
							}
							else{
								console.log(latlng)
							}
						}
					)
				},
				policies: function(){
					that.find('#btn-show-policies').on('click', function(){
						var modal = that.find('#modal-policies');
						modal.modal({
							centered: false,
							onShow: function(){
								$(this).find('#tabs-policies').tab({
									context: '#modal-policies'
								});
							}
						})
						.modal('setting', 'transition', 'horizontal flip')
						.modal('show')
					})
				}
			}
		methods[method].apply(this);
		return this;

		function _showForgotPassword(){
			var modal = that.find('#modal-fpwd')
				.modal({
					closable  : false,
					centered: false,
					//inverted: true
				})
				.modal('setting', 'transition', 'horizontal flip')
				.modal('show')
				.find('#btn-forgot-pwd').on('click', function(){
					var form = that.find('#frm-fpwd');
					form.form({
						fields: FpwdRules,
						onSuccess: function(){
							modal.dimmer({
								closable: false,
								displayLoader: true,
								loaderVariation: 'slow green huge elastic',
								loaderText: Processing
							}).dimmer('show');
						}
					})
				});
		}

		function _showRegisterResume(form){
			var modal = that.find('#modal-register-resume'),
				country = form.find('select[name="country"]'),
				option = country.find('option:selected');

			modal.modal({
				closable  : false
			})
			.modal('setting', 'transition', 'horizontal flip')
			.modal('show');
			modal.find('.user_role').text(form.find('select[name="user_role"]').find('option:selected').text());
			modal.find('.country').html('<i class="'+option.attr('data-flag')+'"></i> '+option.text());
			modal.find('.user_email').text(form.find('input[name="email"]').val());
			modal.find('.first_name').text(form.find('input[name="first_name"]').val());
			modal.find('.last_name').text(form.find('input[name="last_name"]').val());
			modal.find('#btn-register-new-user').on('click', function(e){
				e.stopImmediatePropagation();
				form.submit();
				modal.dimmer({
					closable: false,
					displayLoader: true,
					loaderVariation: 'slow green huge elastic',
					loaderText: Processing
				}).dimmer('show');
			})
		}
	}
})(jQuery);