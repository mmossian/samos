/*
	----------------------------------------------------------------------------------------
	Usuarios
	Location: assets/js
	----------------------------------------------------------------------------------------
*/
(function($) {
	'use strict';
	$.fn.Users = function(method) {
		var that = this,
			methods = {
				personalData: function(){
					that.Phones({});
					validatePersonalData();
				},
				additionalData: function(){
					that.Phones({}, 'add');
					that.Emails({}, 'add');
					submitAdditionals()
				}
			}
		methods[method].apply(this);
		return this;

		function validatePersonalData(){
			var form = that.find('form');
			form.form({
				fields: Rules,
				inline : true,
				on: 'change',
				onSuccess: function(){
					form.dimmer({
						closable: false,
						displayLoader: true,
						loaderVariation: 'slow green huge elastic',
						loaderText: Processing
					}).dimmer('show');
				}
			})
		}

		function validateEmails(){
			var regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/,
				emails = that.find('input[type="email"]'),
				isValid = true;
			if(emails.length > 0){
				emails.each(function(){
					var self = $(this),
						val = $.trim(self.val()),
						error = self.closest('div.field').find('.error-msg');
					if(val != ''){
						if(!regex.test(val)){
							error.removeClass('display-none');
							isValid = false
						}
						else{
							error.addClass('display-none');
							isValid = true
						}
					}
				})
			}
			return isValid
		}

		function validatePhones(){
			var regex = /^([0-9]{6,12})*$/,
				phones = that.find('input[type="text"]'),
				isValid = true;
			if(phones.length > 0){
				phones.each(function(){
					var self = $(this),
						val = $.trim(self.val()),
						error = self.closest('div.field').find('.error-msg');
					if(val != ''){
						if(!regex.test(val)){
							error.removeClass('display-none');
							isValid = false;
						}
						else{
							error.addClass('display-none');
							isValid = true
						}
					}
				})
			}
			return isValid
		}

		function submitAdditionals(){
			var form = that.find('form'),
				btnSave = form.find('#btn-save-additionals');

			btnSave.on('click', function(e){
				e.preventDefault();
				var inputs = form.find('#additional-emails input, #additional-phones input'),
					btnEnable = false;
				if(inputs.length > 0){
					inputs.each(function(){
						var self = $(this),
							val = $.trim(self.val());
						if(val != ''){
							btnEnable = true
						}
					})
				}
				if(btnEnable == true && validateEmails() && validatePhones()){
					that.Phones({}, 'save');
					that.Emails({}, 'save');
					form.dimmer({
						closable: false,
						displayLoader: true,
						loaderVariation: 'slow green huge elastic',
						loaderText: Processing
					}).dimmer('show');
					form.submit()
				}
			})
		}
	}
})(jQuery)