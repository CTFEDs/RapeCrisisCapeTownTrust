(function($) {
delegatePanelInputs = function() {

	var context = 'div#panel';

	/* Selects */	
	$(context).delegate('div.input-select select', 'change', function() {
		
		updatePanelInputHidden({input: $(this), value: $(this).val()});

		var input = $(this);
		var val = $(this).val();
		var toggle = $.parseJSON($(this).attr('toggle'));

		if ( val && toggle && typeof toggle == 'object' ) {

			if ( toggle.hasOwnProperty(val) ) {

				/* Show */
					if ( typeof toggle[val].show == 'string' ) {

						input.parents('.panel').find(toggle[val].show).show();

					} else if ( typeof toggle[val].show == 'object' ) {

						$.each(toggle[val].show, function(index, value) {
							input.parents('.panel').find(value).show();
						});

					}

				/* Hide */
					if ( typeof toggle[val].hide == 'string' ) {

						input.parents('.panel').find(toggle[val].hide).hide();

					} else if ( typeof toggle[val].hide == 'object' ) {

						$.each(toggle[val].hide, function(index, value) {
							input.parents('.panel').find(value).hide();
						});

					}

			} /* end if toggle.hasOwnProperty(val) */ 

		} /* end if ( val && toggle && typeof toggle == 'object' ) */

		allowSaving();
								
	});


	/* Text */
	$(context).delegate('div.input-text input', 'keyup blur', function() {
		
		updatePanelInputHidden({input: $(this), value: $(this).val()});
				
	});
	
	
	/* Textarea */
		$(context).delegate('div.input-textarea textarea', 'keyup blur', function() {
			
			updatePanelInputHidden({input: $(this), value: $(this).val()});
						
		});
		
		$(context).delegate('div.input-textarea span.textarea-open', 'click', function() {
			
			var textareaContainer = $(this).siblings('.textarea-container');
			var textarea = textareaContainer.find('textarea');
			
			var inputContainerOffset = $(this).parents('.input').offset();
			
			textareaContainer.css({
				top: inputContainerOffset.top - textareaContainer.outerHeight(true),
				left: inputContainerOffset.left
			});
			
			/* Keep the sub tabs content container from scrolling */
			$('div.sub-tabs-content-container').css('overflow-y', 'hidden');

			if ( textareaContainer.data('visible') !== true ) {
			
				/* Show the textarea */
				textareaContainer.fadeIn(150);
				textareaContainer.data('visible', true);
			
				/* Put the cursor in the textarea */
				textarea.trigger('focus');
			
				/* Bind the document close */
				$(document).bind('mousedown', {textareaContainer: textareaContainer}, textareaClose);
				Headway.iframe.contents().bind('mousedown', {textareaContainer: textareaContainer}, textareaClose);
			
				$(window).bind('resize', {textareaContainer: textareaContainer}, textareaClose);
			
			} else {
				
				/* Hide the textarea */
				textareaContainer.fadeOut(150);
				textareaContainer.data('visible', false);
				
				/* Allow sub tabs content container to scroll again */
				$('div.sub-tabs-content-container').css('overflow-y', 'auto');

				/* Remove the events */
				$(document).unbind('mousedown', textareaClose);
				Headway.iframe.contents().unbind('mousedown', textareaClose);
				
				$(window).unbind('resize', textareaClose);
				
			}
			
		});
		
		textareaClose = function(event) {
							
			/* Do not trigger this if they're clicking the same button that they used to open the textarea */
			if ( $(event.target).parents('div.input-textarea div.input-right').length === 1 )
				return;
			
			var textareaContainer = event.data.textareaContainer;
			
			/* Hide the textarea */
			textareaContainer.fadeOut(150);
			textareaContainer.data('visible', false);
			
			/* Allow sub tabs content container to scroll again */
			$('div.sub-tabs-content-container').css('overflow-y', 'auto');
			
			/* Remove the events */
			$(document).unbind('mousedown', textareaClose);
			Headway.iframe.contents().unbind('mousedown', textareaClose);
			
			$(window).unbind('resize', textareaClose);
			
		}
	

	/* WYSIWYG */
		inputWYSIWYGChange = function(obj, event) {

			updatePanelInputHidden({input: obj.$el, value: obj.getCode()});
			
		}

		inputWYSIWYGTextareaChange = function() {

			updatePanelInputHidden({input: $(this), value: $(this).val()});
			
		}

		$(context).delegate('div.input-wysiwyg span.wysiwyg-open', 'click', function() {
			
			var wysiwygContainer = $(this).siblings('.wysiwyg-container');
			
			var inputContainerOffset = $(this).parents('.input').offset();
			
			wysiwygContainer.css({
				top: inputContainerOffset.top - wysiwygContainer.outerHeight(true),
				left: inputContainerOffset.left
			});
			
			/* Keep the sub tabs content container from scrolling */
			$('div.sub-tabs-content-container').css('overflow-y', 'hidden');

			if ( wysiwygContainer.data('visible') !== true ) {

				/* Show the WYSWIWYG */
				wysiwygContainer.fadeIn(150);
				wysiwygContainer.css('marginLeft', '');
				wysiwygContainer.data('visible', true);

				/* Make sure WYSIWYG doesn't bleed off screen */
					var possibleBleedingDifference = $(document).width() - (wysiwygContainer.offset().left + wysiwygContainer.width());

					if ( possibleBleedingDifference < 0 ) {
						wysiwygContainer.css('marginLeft', possibleBleedingDifference - 20);
					}

				/* Function for setting up redactor */
					var setupRedactor = function() {

						wysiwygContainer.find('textarea').redactor({
							path: Headway.headwayURL + '/library/resources/redactor/',
							buttons: ['html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|',
								'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
								'table', 'link', '|',
								'fontcolor', 'backcolor', '|', 
								'alignleft', 'aligncenter', 'alignright', 'justify', '|',
								'horizontalrule'],
							allowedTags: ["code", "span", "div", "label", "a", "br", "p", "b", "i", "del", "strike", "u",
"img", "video", "audio", "iframe", "object", "embed", "param", "blockquote",
"mark", "cite", "small", "ul", "ol", "li", "hr", "dl", "dt", "dd", "sup", "sub",
"big", "pre", "code", "figure", "figcaption", "strong", "em", "table", "tr", "td",
"th", "tbody", "thead", "tfoot", "h1", "h2", "h3", "h4", "h5", "h6", "frame", "frameset", "script"],
							keyupCallback: inputWYSIWYGChange,
							execCommandCallback: inputWYSIWYGChange,
							convertDivs: false
						});

						wysiwygContainer.find('textarea')
							.bind('keyup', inputWYSIWYGTextareaChange)
							.setFocus();

						wysiwygContainer.data('setupRedactor', true);

					}

				/* Load redactor if it hasn't been before */
					if ( $('body').data('loadedRedactor') !== true ) {

						var style = $('<link>')
							.attr({
								rel: 'stylesheet',
								href: Headway.headwayURL + '/library/resources/redactor/css/redactor.css', 
								type: 'text/css',
								media: 'screen'
							})
							.appendTo($('head'));

						var script = jQuery.ajax({
							dataType: 'script',
							cache: true,
							url: Headway.headwayURL + '/library/resources/redactor/redactor.min.js',
							complete: setupRedactor
						});

						$('body').data('loadedRedactor', true);

				/* Otherwise just set up redactor if redactor has been loaded, but this input hasn't been setup */
					} else if ( $('body').data('loadedRedactor') === true && wysiwygContainer.data('setupRedactor') !== true ) {

						setupRedactor();

				/* Redactor has been loaded and set up, just focus it */
					} else {

						/* Focus the input */
						wysiwygContainer.find('textarea').setFocus();

					}

				/* Bind the document close */
					$(document).bind('mousedown', {wysiwygContainer: wysiwygContainer}, wysiwygClose);
					Headway.iframe.contents().bind('mousedown', {wysiwygContainer: wysiwygContainer}, wysiwygClose);
					
					$(window).bind('resize', {wysiwygContainer: wysiwygContainer}, wysiwygClose);

			} else {
				
				/* Hide the WYSIWYG */
				wysiwygContainer.fadeOut(150);
				wysiwygContainer.data('visible', false);
				
				/* Allow sub tabs content container to scroll again */
				$('div.sub-tabs-content-container').css('overflow-y', 'auto');

				/* Remove the events */
				$(document).unbind('mousedown', wysiwygClose);
				Headway.iframe.contents().unbind('mousedown', wysiwygClose);
				
				$(window).unbind('resize', wysiwygClose);
				
			}


		});


		wysiwygClose = function(event) {
							
			/* Do not trigger this if they're clicking the same button that they used to open the textarea */
			if ( 
				$(event.target).parents('div.input-wysiwyg div.input-right').length === 1 
				|| $(event.target).parents('.redactor_dropdown').length === 1
				|| $(event.target).parents('#redactor_modal').length === 1 
			)
				return;
			
			var wysiwygContainer = event.data.wysiwygContainer;
			
			/* Hide the WYSIWYG */
			wysiwygContainer.fadeOut(150);
			wysiwygContainer.data('visible', false);
			
			/* Allow sub tabs content container to scroll again */
			$('div.sub-tabs-content-container').css('overflow-y', 'auto');
			
			/* Remove the events */
			$(document).unbind('mousedown', wysiwygClose);
			Headway.iframe.contents().unbind('mousedown', wysiwygClose);
			
			$(window).unbind('resize', wysiwygClose);
			
		}

	
	/* Integer */
	$(context).delegate('div.input-integer input', 'focus', function() {
		
		if ( typeof originalValues !== 'undefined' ) {
			delete originalValues;
		}
		
		originalValues = new Object;		
		originalValues[$(this).attr('name')] = $(this).val();
		
	});
	
	$(context).delegate('div.input-integer input', 'keyup blur', function(event) {
		
		value = $(this).val();
		
		if ( event.type == 'keyup' && value == '-' )
			return;
		
		/* Validate the value and make sure it's a number */
		if ( isNaN(value) ) {

			/* Take the nasties out to make sure it's a number */
			value = value.replace(/[^0-9]*/ig, '');

			/* If the value is an empty string, then revert back to the original value */
			if ( value === '' ) {

				var value = originalValues[$(this).attr('name')];

			}
			
			/* Set the value of the input to the sanitized value */
			$(this).val(value);

		}

		/* Remove leading zeroes */
		if ( value.length > 1 && value[0] == 0 ) {

			value = value.replace(/^[0]+/g, '');
			
			/* Set the value of the input to the sanitized value */
			$(this).val(value);

		}
		
		updatePanelInputHidden({input: $(this), value: value});
				
	});
	
	
	/* Checkboxes */
	$(context).delegate('div.input-checkbox', 'click', function() {
		
		var input = $(this).find('input');
		var label = $(this).find('label');
		var button = $(this).find('span, label');
		
		if ( label.hasClass('checkbox-checked') === true ) {

			button.removeClass('checkbox-checked');
			
			input.val(false);
			
			updatePanelInputHidden({input: input, value: false});

		} else {

			button.addClass('checkbox-checked');
			
			input.val(true);
			
			updatePanelInputHidden({input: input, value: true});

		}

		var val = $(this).find('input').attr('value').toString();
		var toggle = $.parseJSON($(this).find('input').attr('toggle'));

		if ( val && toggle && typeof toggle == 'object' ) {

			if ( toggle.hasOwnProperty(val) ) {

				/* Show */
					if ( typeof toggle[val].show == 'string' ) {

						input.parents('.panel').find(toggle[val].show).show();

					} else if ( typeof toggle[val].show == 'object' ) {

						$.each(toggle[val].show, function(index, value) {
							input.parents('.panel').find(value).show();
						});

					}

				/* Hide */
					if ( typeof toggle[val].hide == 'string' ) {

						input.parents('.panel').find(toggle[val].hide).hide();

					} else if ( typeof toggle[val].hide == 'object' ) {

						$.each(toggle[val].hide, function(index, value) {
							input.parents('.panel').find(value).hide();
						});

					}

			} /* end if toggle.hasOwnProperty(val) */ 

		} /* end if ( val && toggle && typeof toggle == 'object' ) */

		allowSaving();
		
	});


	/* Multi-select */
	$(context).delegate('div.input-multi-select select', 'click', function() {

		updatePanelInputHidden({input: $(this), value: $(this).val()});
							
	});
	
	$(context).delegate('div.input-multi-select span.multi-select-open', 'click', function() {
		
		var multiSelectContainer = $(this).siblings('.multi-select-container');
		var multiSelect = multiSelectContainer.find('select');
		
		var inputContainerOffset = $(this).parents('.input').offset();
		
		multiSelectContainer.css({
			top: inputContainerOffset.top - multiSelectContainer.outerHeight(true),
			left: inputContainerOffset.left
		});
		
		/* Keep the sub tabs content container from scrolling */
		$('div.sub-tabs-content-container').css('overflow-y', 'hidden');
		
		if ( multiSelectContainer.data('visible') !== true ) {
		
			/* Show the multi-select */
			multiSelectContainer.fadeIn(150);
			multiSelectContainer.data('visible', true);
		
			/* Bind the document close */
			$(document).bind('mousedown', {multiSelectContainer: multiSelectContainer}, multiSelectClose);
			Headway.iframe.contents().bind('mousedown', {multiSelectContainer: multiSelectContainer}, multiSelectClose);
			
			$(window).bind('resize', {multiSelectContainer: multiSelectContainer}, multiSelectClose);
		
		} else {
			
			/* Hide the multi-select */
			multiSelectContainer.fadeOut(150);
			multiSelectContainer.data('visible', false);
			
			/* Allow sub tabs content container to scroll again */
			$('div.sub-tabs-content-container').css('overflow-y', 'auto');

			/* Remove the events */
			$(document).unbind('mousedown', multiSelectClose);
			Headway.iframe.contents().unbind('mousedown', multiSelectClose);
			
			$(window).unbind('resize', multiSelectClose);
			
		}
		
	});
	
	multiSelectClose = function(event) {
				
		/* Do not trigger this if they're clicking the same button that they used to open the multi-select */
		if ( $(event.target).parents('div.input-multi-select div.input-right').length === 1 )
			return;
		
		var multiSelectContainer = event.data.multiSelectContainer;
		
		/* Hide the multi-select */
		multiSelectContainer.fadeOut(150);
		multiSelectContainer.data('visible', false);
		
		/* Allow sub tabs content container to scroll again */
		$('div.sub-tabs-content-container').css('overflow-y', 'auto');
		
		/* Remove the events */
		$(document).unbind('mousedown', multiSelectClose);
		Headway.iframe.contents().unbind('mousedown', multiSelectClose);
		
		$(window).unbind('resize', multiSelectClose);
		
	}
	

	/* Image Uploaders */
	$(context).delegate('div.input-image span.button', 'click', function() {
		
		var self = this;
		
		openImageUploader(function(url, filename) {
						
			$(self).siblings('input').val(url);
			$(self).siblings('span.src').show().text(filename);

			$(self).siblings('span.delete-image').show();

			updatePanelInputHidden({input: $(self).siblings('input'), value: url, action: 'add'});	
			
		});

	});
	
	$(context).delegate('div.input-image span.delete-image', 'click', function() {

		if ( !confirm('Are you sure you wish to remove this image?') ) {
			return false;
		}

		$(this).siblings('.src').hide();
		$(this).hide();

		$(this).siblings('input').val('');

		updatePanelInputHidden({input: $(this).siblings('input'), value: '', action: 'delete'});

	});


	/* Repeaters */
		updateRepeaterValues = function(repeater) {

			var values = {};

			repeater.find('div.repeater-group:visible').each(function(index) {

				var groupValues = {};

				$(this).find('select, input, textarea').each(function() {
					groupValues[$(this).attr('name')] = $(this).val();
				});

				values[index] = groupValues;

			});

			return updatePanelInputHidden({input: repeater.find('input.repeater-group-input'), value: values});	

		}

		$(context).delegate('div.repeater .add-group', 'click', function() {
			
			var repeater = $(this).parents('div.repeater');
			var group = $(this).parents('div.repeater-group');
			var groupTemplate = repeater.find('.repeater-group-template');

			/* If the limit is met then don't add a new group */
				if ( repeater.hasClass('limit-met') )
					return;

			/* Clone repeater template */
				var newGroup = groupTemplate.clone().hide().removeClass('repeater-group-template');
				newGroup.insertAfter(group).fadeIn(300);

			/* Remove group single class since there's no longer one group */
				repeater.find('.repeater-group-single').removeClass('repeater-group-single');

			/* Add limit-met class if necessary */
				var repeaterLimit = repeater.data('repeater-limit');

				if ( !isNaN(repeaterLimit) && repeaterLimit >= 1 && repeater.find('div.repeater-group:not(.repeater-group-template):visible').length == repeaterLimit )
					repeater.addClass('limit-met');

			updateRepeaterValues(repeater);
			
		});

		$(context).delegate('div.repeater .remove-group', 'click', function() {

			if ( !confirm('Are you sure?') )
				return;
			
			var repeater = $(this).parents('div.repeater');
			var group = $(this).parents('div.repeater-group');
			
			/* Fade out that way history can revert it.  The updatePanelHidden will be based off of if the group is :visible or not */
				group.fadeOut(300, function() {

					/* if there's only one group left, then add the repeater group single class */
						if ( repeater.find('div.repeater-group:visible').length === 1 )
							repeater.find('div.repeater-group:visible').addClass('repeater-group-single');

					/* Remove limit-met class if necessary */
						var repeaterLimit = repeater.data('repeater-limit');

						if ( !isNaN(repeaterLimit) && repeaterLimit >= 1 && repeater.find('div.repeater-group:not(.repeater-group-template):visible').length < repeaterLimit )
							repeater.removeClass('limit-met');

					updateRepeaterValues(repeater);

				});
			
		});


	/* Color Inputs */
	$(context).delegate('div.input-colorpicker div.colorpicker-box', 'click', function() {

		/* Keep the sub tabs content container from scrolling */
		$('div.sub-tabs-content-container').css('overflow-y', 'hidden');	

		/* Set up variables */
		var input = $(this).parent().siblings('input');
		var inputVal = input.val();

		if ( inputVal == 'transparent' )
			inputVal = '00FFFFFF';

		var colorpickerHandleVal = function(color, inst) {

			var colorValue = '#' + color.hex;

			/* If alpha ISN'T 100% then use RGBa */
			if ( color.a != 100 )
				var colorValue = color.rgba;

			input.val(colorValue);
			updatePanelInputHidden({input: input, value: color});

			/* Call developer-defined callback */
				var callback = eval(input.attr('callback'));

				if ( typeof callback == 'function' ) {

					callback({
						input: input,
						value: color.rgba,
						colorObj: color
					});

				}
			/* End Callback */
		
		}

		$(this).colorpicker({
			realtime: true,
			alpha: true,
			alphaHex: true,
			allowNull: false,
			swatches: (typeof Headway.colorpickerSwatches == 'object' && Headway.colorpickerSwatches.length) ? Headway.colorpickerSwatches : true,
			color: inputVal,
			beforeShow: function(input, inst) {

				/* Add iframe overlay */
				showIframeOverlay();

			},
			onClose: function(color, inst) {

				colorpickerHandleVal(color, inst);

				/* Hide iframe overlay */
				hideIframeOverlay();

				/* Allow sub tabs content container to scroll again */
				$('div.sub-tabs-content-container').css('overflow-y', 'auto');

			},
			onSelect: function(color, inst) {

				colorpickerHandleVal(color, inst);

			},
			onAddSwatch: function(color, swatches) {

				updatePanelInputHidden({
					group: 'general',
					id: 'colorpicker-swatches',
					value: swatches
				});

			},
			onDeleteSwatch: function(color, swatches) {

				updatePanelInputHidden({
					group: 'general',
					id: 'colorpicker-swatches',
					value: swatches
				});

			}
		});

		$.colorpicker._showColorpicker($(this));

		setupTooltips();
						
	});


	/* Buttons */
		$(context).delegate('div.input-button span.button', 'click', function() {
			
			var callback = eval($(this).attr('callback'));

			if ( typeof callback == 'function' )
					callback({input: $(this)});
			
		});


	/* Import Files */
		$(context).delegate('div.input-import-file span.button', 'click', function() {
			
			$(this).siblings('input[type="file"]').trigger('click');
			
		});

		$(context).delegate('div.input-import-file input[type="file"]', 'change', function(event) {
			
			if ( event.target.files[0].name.split('.').slice(-1)[0] != 'json' ) {

				$(this).val(null);
				return alert('Invalid skin.  Please be sure that the skin is a valid JSON formatted file.');

			}

			$(this).siblings('span.src').show().text($(this).val().split(/(\\|\/)/g).pop());
			$(this).siblings('span.delete-file').show();

			var callback = eval($(this).attr('callback'));

			if ( typeof callback == 'function' )
					callback({input: $(this)});
			
		});

		$(context).delegate('div.input-import-file .delete-file', 'click', function() {
			
			if ( !confirm('Are you sure?') )
				return;

			$(this).fadeOut(100);
			$(this).siblings('span.src').fadeOut(100);

			var fileInput = $(this).siblings('input[type="file"]');
			var callback = eval(fileInput.attr('callback'));

			fileInput.val(null);

			if ( typeof callback == 'function' )
					callback({input: fileInput});
			
		});



}

bindPanelInputs = function(context) {

	if ( typeof context === 'undefined' )
		var context = 'div#panel';

	/* Sliders */
		$('div.input-slider div.input-slider-bar', context).each(function() {
			
			var self = this;

			var value = parseInt($(this).parents('.input-slider').find('input.input-slider-bar-hidden').val());

			var min = parseInt($(this).attr('slider_min'));
			var max = parseInt($(this).attr('slider_max'));
			var interval = parseInt($(this).attr('slider_interval'));

			$(this).slider({
				range: 'min',
				value: value,
				min: min,
				max: max,
				step: interval,
				slide: function( event, ui ) {
					
					/* Update visible output */
					$(this).siblings('div.input-slider-bar-text').find('span.slider-value').text(ui.value);

					/* Update hidden input */
					$(this).parents('.input-slider').find('input.input-slider-bar-hidden').val(ui.value);

					/* Handle hidden input */
					updatePanelInputHidden({input: $(this).parents('.input-slider').find('input.input-slider-bar-hidden'), value: ui.value});
					
				}
			});
			
		});

	/* Repeaters */
		/* Repeater Sortables */
			$('.repeater-sortable', context).sortable({
				items: '.repeater-group', 
				containment: 'parent',
				forcePlaceholderSize: true,
				handle: '.sortable-handle',
				stop: function() {
					updateRepeaterValues($(this));
				}
			});

		/* Repeater Limits */
			$('.repeater', context).each(function() {

				var repeaterLimit = $(this).data('repeater-limit');

				if ( !isNaN(repeaterLimit) && repeaterLimit >= 1 && $(this).find('div.repeater-group:not(.repeater-group-template):visible').length >= repeaterLimit )
					$(this).addClass('limit-met');

			});

}
})(jQuery);