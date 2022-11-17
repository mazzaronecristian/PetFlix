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
			let overlay = document.getElementsByClassName("overlay");
			let $overlay = $(overlay);

			$openButton.on('click', function(){
				$this.find('.modal').addClass('active');
				$overlay.addClass('active');
			});

			$addButton.on('click', function(){
				let $field = $this.find('.newTimes');
				let html = 	"<div class=\"time\"><input class=\"time-field\" type=\"time\" value=\"00:00\"><button onclick=\"closeField(this)\" class=\"edit remove\"><i class=\"fa-solid fa-minus\"></i></button></div>";

				$field.append(html);
			});

			$closeButton.on('click', function(){
				$this.find('.modal').removeClass('active');
				$overlay.removeClass('active');
				close_pop_up($this);
			});

			$overlay.on('click', function(){
				$this.find('.modal').removeClass('active');
				$overlay.removeClass('active');
				close_pop_up($this);
			});
			loadTimes($this);
		});

		//inizio funzioni per interagire col db
		function sendTimes($el){
			$form = $el.find(".newTimes");
			var type = $form.parent().attr("id").slice(5);
			var flag = null;
			if (type=="food") flag = 0;
			if (type=="walk") flag = 1
			$form.find(".time-field").each(function(){
				var time = $(this).val();
				var request = $.ajax({
					url: options.serverURL,
					type: "POST",
					data: {
						"time" : time, 
						"flag" : flag,
						"action" : "insert"
					},
					dataType: "json"
				});

				request.done(function(data) {
					console.log("DONE");
					handleInsert(time, $el.find('ul.times'));
					//TODO handleInsert(data, $this) per scrivere gli orari dal popup all'elenco sulla pagina
				});
				request.fail(function(){
					console.log("fail");
				});

			});
		}

		function handleInsert(time, $position){
			//$position = $el.find('ul.times');
			$position.append("<li>"+time+"</li>");
		}

		function loadTimes($el){
			var request = $.ajax({
				url : options.serverURL,
				type: "POST",
				data:{
					"action" : "load"
				},
				dataType: "json"
			});

			request.done(function(data) {
				handleLoad(data, $el);
			});
	 
			request.fail(function(jqXHR, textStatus) {
					alert( "Request failed: " + textStatus );
			});		
		}

		function handleLoad(data, $el){
			$position = $el.find('ul.times');
			var times = data['times'];
			html = "";

			if(times.length>0){
				$(times).each(function(index, object){
					html += "<li>"+object['time']+"</li>";
				});
				$position.append(html);
			}
		}

		function load_pop_up($el) {
			var classList = $el.attr("class");
			var classArr = classList.split(" ");
			console.log(classArr[0]);
			let html = '<button data-modal-target="#modalFood" class="edit open"><i class="fa-solid fa-pencil"></i></button>';
			html +='<div class="modal">'+
							'<div class="modal-header">'+
								'<div class="title">Modifica gli orari</div>'+
								'<button data-close-button class="close-button"><i class="fa-solid fa-xmark"></i></button>'+
							'</div>'+
							'<div class="modal-body" id="modal'+classArr[0]+'">'+
		 						'<form class="newTimes">'+

								'</form>'+
								'<button data-add-time-field class="edit add"><i class="fa-solid fa-plus"></i></button>'+	
						'</div>'+
					'</div>';
			$el.append(html);
		}	

		function close_pop_up($el){
			let $form = $el.find('.newTimes');
			var input = $('input.time-field', $form);
			let html = '';

			//invio del contenuto del popup al db
			sendTimes($el);
		}
	}
})(jQuery);

//TODO modificare funzione closeField() e scriverla con jQuery
function closeField(button){
	let field = button.closest('.time')
	field.remove()
}

