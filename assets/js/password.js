(function($){
	'use strict';

	$.fn.showHidePwd = function(){
		var input = this.find('input.password');
		$.each(input, function(){
			var self = $(this);
			if(self.attr('type') == 'password'){
				self.attr('type', 'text')
			}
			else{
				self.attr('type', 'password')
			}
		})
		return this
	}

	$.fn.randomPassword = function(options){
		var defaults = {
			minlength: 6,
			maxlength: 20,
			fixedlength: 0,
			type: 'alfanum' // alfanum, alfa, num, specialchars
		};
		var settings = $.extend(defaults, options);
		var ascii_val = 0;
		var ascii = '';
		var len = 0;
		//if(settings.fixedlength>settings.minlength && settings.fixedlength<=settings.maxlength){
		if(settings.fixedlength > 0){
			len = settings.fixedlength
		}
		else{
			len = Math.round((Math.random() * settings.maxlength));
			if(len<settings.minlength){
				len = settings.minlength
			}
		}

		do{
			ascii_val = Math.floor(Math.random()*126);
			if(settings.type == 'alfanum'){
				if((ascii_val>47 && ascii_val<58) || (ascii_val>64 && ascii_val<91) || (ascii_val>96 && ascii_val<123)){
					ascii += String.fromCharCode(ascii_val);
				}
			}
			else if(settings.type == 'alfa'){
				if((ascii_val>64 && ascii_val<91) || (ascii_val>96 && ascii_val<123)){
					ascii += String.fromCharCode(ascii_val);
				}
			}
			else if(settings.type == 'num'){
				if((ascii_val>47 && ascii_val<58)){
					ascii += String.fromCharCode(ascii_val);
				}
			}
			else if(settings.type == 'specialchars'){
				if((ascii_val>32 && ascii_val<126)){
					ascii += String.fromCharCode(ascii_val);
				}
			}
		}while(ascii.length < len)

		if(this.is('input')){
			this.val(ascii)
		}
		else if(this.is('div') || this.is('span') || this.is('p')){
			this.text(ascii)
		}
		else{
			return ascii
		}
		return this;
	}
	$.fn.modalRandomPassword = function(){
		DomRootEl.find('#btn-random-pwd').on('click', function(e){
			var modal = DomRootEl.find('#modal-random-pwd');
			modal.modal({
				centered: false,
				onVisible: function(){
					var self = $(this);
					self.find('select.dropdown').dropdown();
					self.find('#generate-rand-pwd').on('click', function(){
						var genPwd = self.find('#pwd-generated'),
							copied = self.find('#pwd-copied'),
							btnCancel = self.find('button.cancel');

						btnCancel.prop('disabled', false);
						genPwd.randomPassword({
							type: modal.find('select[name="pwd_type"]').val(),
							fixedlength: modal.find('input[name="pwd_len"]').val()
						})
						.siblings('i')
						.on('click', function(e){
							e.stopImmediatePropagation();
							if(genPwd.val() != ''){
								var pwd = copyText('pwd-generated');
								copied.removeClass('display-none')
							}
						});

						self.find('input[name="pwd_len"], select[name="pwd_type"]').on('change', function(){
							btnCancel.prop('disabled', true);
							genPwd.val('').siblings('i');
							copied.addClass('display-none')
						});
						btnCancel.on('click', function(){
							if(genPwd.val() != ''){
								DomRootEl.find('input[name="newpwd"], input[name="rnewpwd"]').val(genPwd.val())
							}
						})
					});
				}
			})
			.modal('setting', 'transition', 'horizontal flip')
			.modal('show')
		})
	}

	$.fn.resetPassword = function(){
		var form = this.find('form'),
			input = form.find('#random-pwd'),
			pwd = form.find('input[name="rndpwd"]');
		form.find('#btn-random-pwd').on('click', function(){
			input.closest('div').removeClass('disabled');
			input.randomPassword({fixedlength: 10});
			form.find('#copied')
				.removeClass('display-none')
				.find('span').text(input.val());
			pwd.val(input.val());
			copyText('random-pwd');
			input.closest('div').addClass('disabled');
		})
		form.find('#btn-reset-pwd').on('click', function(e){
			e.preventDefault();
			if(pwd.val() === input.val()){
				form.form({
					fields: Rules,
					onSuccess: function(){
						that.find('#container').dimmer({
							closable: false,
							displayLoader: true,
							loaderVariation: 'slow green huge elastic',
							loaderText: Processing
						}).dimmer('show');
					}
				}).submit();
			}
		})
	}
})(jQuery);