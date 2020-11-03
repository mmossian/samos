/*
	----------------------------------------------------------------------------------------
	Inicializacion de la aplicacion
	Location: assets/js
	----------------------------------------------------------------------------------------
*/
(function($) {
	'use strict';
	$.fn.Init = function(method) {
		var that = this,
			methods = {
				construct: function(){
					var msg = that.find('#toast-message');
					if(msg.length > 0){
						that.toast(JSON.parse(msg.val()))
					}
					that.find('.popover').popup();
				},
				home: function(){

				},
				register: function(){
					// that.find('.dropdown').dropdown();
					// that.find('.checkbox').checkbox();
					// that.Auth('signUp');
				},
				login: function(){
					that.Auth('login');
				},
				// recover_pwd: function(){
				// 	that.Password('recover')
				// },
				// restore_pwd: function(){
				// 	that.Password('recover')
				// },
				// login: function(){
				// 	$('body').addClass('login');
				// 	that.Auth('login');
				// },
				// signup: function(){
				// 	// that.Auth('signUp');
				// },
			};

		methods.construct();
		if(method != undefined){
			methods[method].apply(this)
		}
		return this;

		/*
			METTODOS PRIVADOS
		*/

		/*function _setLogout(){
			var form = that.find('#frm-logout'),
				logout = that.find('#logout');
			logout.on('click', function(){
				form.submit()
			})
		}*/

	}
})(jQuery);

function formatDate(value){
	var d = value.split(' '),
		date = d[0].split('-'),
		time = d[1].split(':');
	return date[2]+'/'+date[1]+'/'+date[0]+' '+time[0]+':'+time[1];
}

function _setBsTable(idTable){
 	var tbl = DomRootEl.find(idTable);
	tbl.bootstrapTable('destroy').bootstrapTable({
		locale: 'es-AR',
		search: true,
		sortable: true,
		pagination: true,
		showFullscreen: false,
		iconsPrefix: 'icon',
		pageSize: 25,
		icons: {
			paginationSwitchDown: 'angle down',
		    paginationSwitchUp: 'angle up',
		    refresh: 'sync',
		    toggleOff: 'eye slash',
		    toggleOn: 'eye',
		    export: 'clone',
		    columns: 'columns',
		    fullscreen: 'expand arrows alternate',
		    detailOpen: 'plus',
		    detailClose: 'minus'
		},
		buttonsPrefix: '',
		buttonsClass: 'ui button small secondary'
	})
}

function exportTable(idTable){
	var tbl = DomRootEl.find(idTable),
		ignore = tbl.find('thead th').length - 1;

	tbl.find('a[data-type="csv"]').on('click', function(){
		tbl.tableExport({
			type: 'csv',
			jsonScope: 'all',
			ignoreColumn: [ignore]
		});
	});
	DomRootEl.find('#btn-export-pdf').on('click', function(){
		tbl.tableExport({
			type: 'pdf',
			jsonScope: 'all',
			ignoreColumn: [ignore],
			jspdf: {
				orientation: 'l',
				format: 'a3',
				margins: {left:10, right:10, top:20, bottom:20},
				autotable: {
					styles: {
						fillColor: 'inherit',
						textColor: 'inherit'
					},
					tableWidth: 'auto'
				}
			}
		});
	})
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

function validate(inline, rule_id){
	var id_rule = rule_id == undefined ? '#rules' : rule_id,
		rules = DomRootEl.find(id_rule),
		form =  rules.closest('form');
	form.form({
		fields: $.parseJSON(rules.val()),
		inline: inline,
		onSuccess: function(event, fields){
			setDimmer()
		}
	})
}

function setDimmer(el){
	var element = el == undefined ? $('body') : el;
	element.dimmer({
		displayLoader: true,
		loaderVariation: 'slow orange big elastic',
		loaderText: Processing,
		closable: false
	})
	.dimmer('show')
}

function randomNumber(element){
	var min = 10000,
		max = 100000,
		random = Math.floor(Math.random() * (max - min)) + min;
	element.attr('placeholder', Processing);
	DomRootEl.request({
		url: BaseUrl+'check-code-property',
		type: 'GET',
		data: {code: random}
	}).then(
		function(response){
			if(response > 0){
				randomNumber(element)
			}
			else{
				element.val(random);
				element.attr('placeholder', '')
			}
		}
	)
}

function print(element){
	element.print({
		globalStyles: true,
		mediaPrint: true,
		stylesheet: null,
		noPrintSelector: ".no-print",
		iframe: true,
		append: null,
		prepend: null,
		manuallyCopyFormValues: true,
		deferred: $.Deferred(),
		timeout: 750,
		title: null,
		doctype: '<!doctype html>'
	});
}

function formatMoney(amount, decimalCount = 2, decimal = ".", thousands = ",") {
  try {
    decimalCount = Math.abs(decimalCount);
    decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

    const negativeSign = amount < 0 ? "-" : "";

    let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
    let j = (i.length > 3) ? i.length % 3 : 0;

    console.log(i, j)

    return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
  } catch (e) {
    console.log(e)
  }
};

function roundTo(n, digits) {
    var negative = false,
    	multiplicator,
    	numStr;
    if (digits === undefined) {
        digits = 2;
    }
    if( n < 0) {
        negative = true;
      	n = n * -1;
    }
    multiplicator = Math.pow(10, digits);
    n = parseFloat((n * multiplicator).toFixed(11));
    n = (Math.round(n) / multiplicator).toFixed(2);
    if( negative ) {
        n = (n * -1).toFixed(2);
    }
    return n;
}
