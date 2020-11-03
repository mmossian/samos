(function($) {
	'use strict';
	$.fn.Auth = function(method) {
		var that = this,
			methods = {
				login: function(){
					validate(true)
				},
				signUp: function(){
					var form = that.find('form'),
						rules = $.parseJSON(form.find('#rules').val());
					form.find('.dropdown').dropdown();
					validate(true)
				}
			}
		methods[method].apply(this);
		return this;
	}
})(jQuery);
