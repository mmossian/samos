(function($){
	$.fn.request = function(options){
		var defaults = {
				url: BaseUrl,
				data:null,
				type: 'POST',
				showLoadingBar: false,
				overlay: false,
				dataType: 'html',
				loadingBarText: ''
			},
			settings = $.extend(true, defaults, options),
			that = this,
			data = settings.data != null ? settings.data : this.serialize(),
			dfd = $.Deferred();
			ajax = $.ajax({
			url: settings.url,
			method: settings.type,
			data: data,
			dataType: settings.dataType,
			success: function(response){
				dfd.resolve(response)
			},
			error: function(){
				if(settings.showLoadingBar){
					DomRootEl.find('.loading-bar').remove();
				}
				if(settings.overlay){
					$('body').removeClass('overlay');
				}
				dfd.reject('error_no_request');
			},
			beforeSend: function(){
				if(settings.showLoadingBar){
					DomRootEl.loadingBar({text: settings.loadingBarText});
				}
				if(settings.overlay){
					$('body').addClass('overlay');
				}
			},
			complete: function(){
				if(settings.showLoadingBar){
					DomRootEl.find('.loading-bar').remove();
				}
				if(settings.overlay){
					$('body').removeClass('overlay');
				}
			}
		})
		return dfd.promise()
	}
})(jQuery);