(function($){
	$.fn.times = function(options){
		var defaults = {
			serverURL : "example.com/server_page_url",
		}
		options = $.extend(defaults, options);

		return this.each(function(i, obj) {
			let $this = $(this);
			load_pop_up($this);
			let $openButton = $('.open', $this);//$this = .selezioneOrari
			let $addButton = $('.add', $this);
			let $closeButton = $('.close-button', $this);
			let $overlay = $('.overlay', $this);

			$openButton.on('click', function(){
				$this.find('.modal').addClass('active');
				$this.find('.overlay').addClass('active');
			});

			$addButton.on('click', function(){
				let $field = $this.find('.newTimes');
				let html = 	"<div class=\"time\"><input class=\"time-field\" type=\"time\" value=\"00:00\"><button onclick=\"closeField(this)\" class=\"edit remove\"><i class=\"fa-solid fa-minus\"></i></button></div>";

				$field.append(html);
			});

			$closeButton.on('click', function(){
				close_pop_up($this);
			});

			$overlay.on('click', function(){
				close_pop_up($this);
			});

		

			function load_pop_up($el) {
				let html = '<button data-modal-target="#modalFood" class="edit open"><i class="fa-solid fa-pencil"></i></button>';
				html += '<div class="modal" id="modalFood">'+
							'<div class="modal-header">'+
								'<div class="title">Modifica gli orari</div>'+
								'<button data-close-button class="close-button"><i class="fa-solid fa-xmark"></i></button>'+
							'</div>'+
							'<div class="modal-body">'+
			 					'<form class="newTimes">'+

								'</form>'+
								'<button data-add-time-field class="edit add"><i class="fa-solid fa-plus"></i></button>'+		
							'</div>'+	
						'</div>'+ 
						'<div class="overlay"></div>';
				$el.append(html);
			}	

			function close_pop_up($el){
				$el.find('.modal').removeClass('active');
				$el.find('.overlay').removeClass('active');
				let $form = $el.find('.newTimes');
				var input = $('input.time-field', $form);
				let html = '';

				//invio del contenuto del popup al db
				sendTimes($form);

				for (var i = 0; i < input.length; i++) {
					html += '<li>'+$form.find(input[i]).val()+'</li>';
				}

				let $times = $el.find('ul.times');
				$times.append(html);
			}

			function sendTimes($form){
				var $text = $form.find(".time-field");
				var text = $text.val();
				var type = "pasto";

				var request = $.ajax({
					url: options.serverURL,
					type: "POST",
					data: {"text" : text, "action" : "insert"},
					dataType: "json",
				});

				request.done(function(data) {
					console.log("REQUEST.DONE: " + data)
					handleInsert(data, $this);
				});
			}
		});
	}
})(jQuery);

function closeField(button){
	let field = button.closest('.time')
	field.remove()
}