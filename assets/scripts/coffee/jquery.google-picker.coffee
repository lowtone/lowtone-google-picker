$ = @jQuery

google = @google

picker_options = @lowtone_google_picker

$.fn.google_picker = (method) ->
	defaults = {}

	picker_callback = (data, options) ->
		if google.picker.Action.PICKED == data[google.picker.Response.ACTION]
			doc = data[google.picker.Response.DOCUMENTS][0]
			url = doc[google.picker.Document.URL]

			data = 
				action: "lowtone_google_picker_#{options.picker_id}"
				picker_id: options.picker_id
				url: url

			success = (response) ->
				return if !response.meta

				switch response.meta.code
					when 200
						return if !response.data

						console.dir response.data

			$.getJSON picker_options.ajaxurl, data, success

	methods = 
		init: (options) ->
			$element = $ this

			options = $.extend null, ($element.data 'picker' || {}), options

			$element.click ->
				methods.open options

		open: (options) ->
			instance_callback = (data) ->
				picker_callback data, options

			options = $.extend null, defaults, options

			picker = new google.picker.PickerBuilder()

			add_view = (view) ->
				picker.addView google.picker.ViewId[view]

			add_view view for view in options.views

			picker = picker
				.setCallback(instance_callback)
				.build()

			picker.setVisible true

	if methods[method]
		methods[method].apply this, Array::slice.call(arguments, 1)
	else if typeof method is "object" or not method
		methods.init.apply this, arguments
	else
		$.error "Method #{method} does not exist on jQuery.picker"


google.setOnLoadCallback ->
	$ ->
		$('.lowtone.google.picker').google_picker()

load_options = 
	language: picker_options.language

google.load 'picker', '1', load_options