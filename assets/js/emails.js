/*
	----------------------------------------------------------------------------------------
	Emails asociados
	Location: assets/js
	----------------------------------------------------------------------------------------
*/
(function($) {
	'use strict';
	$.fn.Emails = function(options, method) {
		var defaults = {
				idPhone: null
			},
			settings = $.extend(true, defaults, options),
			that = this,
			container = that.find('#additional-emails'),
			max = container.attr('data-max-emails'),
			hidden = that.find('#hidden-emails').children(),
			hiddenData = that.find('input[name="additionals_emails"]'),
			btnAdd = that.find('#btn-add-additional-email'),
			methods = {
				construct: function(){
					var additionalEmails = $.parseJSON(hiddenData.val());
					if(additionalEmails.length == max){
						btnAdd.addClass('disabled')
					}
				},
				add: function(){
					var additionalEmails = $.parseJSON(hiddenData.val()),
						idEmails = [];

					if(additionalEmails.length > 0){
						$.each(additionalEmails, function(k, v){
							if(v.id_email != undefined){
								idEmails.push(v.id_email)
							}
							_clone(v);
						})
					}
					btnAdd.on('click', function(e){
						e.stopImmediatePropagation();
						var elems = container.find('div.field').length;
						if(elems < max){
							_clone()
						}
						else{
							btnAdd.addClass('disabled')
						}
					})
				},
				save: function(){
					var els = container.find('input[type="email"]'),
						values = hiddenData,
						vals = $.parseJSON(values.val()),
						index = 0,
						emails = [];
					els.each(function(){
						var self = $(this),
							val = $.trim(self.val());

						if(vals[index] != undefined){
							emails.push(
								{email: val, id_email: vals[index].id_email}
							);
							index++
						}
						else{
							if(val != ''){
								emails.push(
									{email: val}
								)
							}
						}
					})
					values.val(JSON.stringify(emails))
				}
			}
		methods.construct();
		methods[method].apply(this);
		return this;

		function _clone(email){
			var clone = hidden.clone(true);
			clone
				.appendTo(container)
				.find('input').val(email != undefined ? email.email : '');
			clone
				.find('.btn-delete-email')
				.on('click', function(e){
					e.stopImmediatePropagation();
					if(email != undefined){
						deleteEmail(email.id_email, $(this))
					}
					else{
						$(this).closest('div.field').remove();
					}
					btnAdd.removeClass('disabled')
				});
		}

		function deleteEmail(id_email, btn){
			btn.addClass('loading');
			$.fn.request({
				url: BaseUrl+'index.php/removeadditionalemail',
				type: 'GET',
				data: {id_email: id_email},
				dataType: 'text'
			}).then(function(response){
				if(response == 1){
					var hide = hiddenData,
						values = $.parseJSON(hide.val());
					for(var i=0; i<values.length; i++){
						if(values[i].id_email == id_email){
							values.splice(i, 1);
							break;
						}
					}
					hide.val(JSON.stringify(values));
					btn.closest('div.field').remove()
				}
				btn.removeClass('loading');
			})
		}
	}
})(jQuery)