/*
	----------------------------------------------------------------------------------------
	Telefonos asociados
	Location: assets/js
	----------------------------------------------------------------------------------------
*/
(function($) {
	'use strict';
	$.fn.Phones = function(options, method) {
		var defaults = {
				idPhone: null
			},
			settings = $.extend(true, defaults, options),
			that = this,
			methods = {
				construct: function(){
					that.find('.dropdown').dropdown({
						sortSelect: true
					})
				},
				add: function(){
					var container = that.find('#additional-phones'),
						additionalPhones = $.parseJSON(that.find('input[name="additionals_phones"]').val()),
						max = container.attr('data-max-phones'),
						btnAdd = that.find('#btn-add-additional-phone'),
						idPhones = [];

					if(additionalPhones.length == max){
						btnAdd.addClass('disabled')
					}
					if(additionalPhones.length > 0){
						$.each(additionalPhones, function(k, v){
							if(v.id_phone != undefined){
								idPhones.push(v.id_phone)
							}
							_clone(container, v);
						})
					}
					btnAdd.on('click', function(e){
						e.stopImmediatePropagation();
						var elems = container.find('div.field');
						if(elems.length < max){
							_clone(container)
						}
						else{
							btnAdd.addClass('disabled')
						}
					})
				},
				save: function(){
					var els = that.find('#additional-phones input[type="text"]'),
						values = that.find('input[name="additionals_phones"]'),
						vals = $.parseJSON(values.val()),
						index = 0,
						phones = [];
					els.each(function(){
						var self = $(this),
							phone = $.trim(self.val()),
							prefix = $.trim(self.closest('div.field').find('select').val());

						if(vals[index] != undefined){
							phones.push(
								{phone_number: phone, phone_prefix: prefix, id_phone: vals[index].id_phone}
							);
							index++
						}
						else{
							if(phone != ''){
								phones.push(
									{phone_number: phone, phone_prefix: prefix}
								)
							}
						}
					})
					values.val(JSON.stringify(phones))
				}
			}
		methods.construct();
		if(method != undefined){
			methods[method].apply(this);
		}
		return this;

		function _clone(c, phone){
			var hidden = that.find('#hidden-phones').children(),
				btnAdd = that.find('#btn-add-additional-phone'),
				clone = hidden.clone(true);

			clone
				.appendTo(c)
				.find('input').val(phone != undefined ? phone.phone_number : '');
			clone.find('.btn-delete-phone')
				.on('click', function(e){
					e.stopImmediatePropagation();
					if(phone != undefined){
						deletePhone(phone.id_phone, $(this))
					}
					else{
						$(this).closest('div.field').remove();
					}
					btnAdd.removeClass('disabled')
				});
			if(phone != undefined){
				clone.find('select').val(phone.phone_prefix);
			}

			clone.find('.dropdown').dropdown({
				sortSelect: true
			});
		}

		function deletePhone(id_phone, btn){
			btn.addClass('loading');
			$.fn.request({
				url: BaseUrl+'index.php/removeadditionalphone',
				type: 'GET',
				data: {id_phone: id_phone},
				dataType: 'text'
			}).then(function(response){
				if(response == 1){
					var hidden = that.find('input[name="additionals_phones"]'),
						values = $.parseJSON(hidden.val());
					for(var i=0; i<values.length; i++){
						if(values[i].id_phone == id_phone){
							values.splice(i, 1);
							break;
						}
					}
					hidden.val(JSON.stringify(values));
					btn.closest('div.field').remove()
				}
				btn.removeClass('loading');
			})
		}
	}
})(jQuery)