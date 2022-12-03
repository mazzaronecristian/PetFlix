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
				var count = $field.find("div.time").length;
				if(count == 5){
					alert("Non puoi programmare più di 5 pasti");
					return;
				}
				let html = 	"<div class=\"time\"><input class=\"time-field\" type=\"time\" value=\"00:00\"><button type='button' class=\"edit remove\"><i class=\"fa-solid fa-minus\"></i></button></div>";
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

			$("body").on("click", ".remove", function() {
				let field = $(this).parent();
				removeTimes($(field), $this);
				$(field).remove();

			});

			loadTimes($this);
		});

		function removeTimes($field, $el){
			let id = $field.attr("id");
			var request = $.ajax({
				url: options.serverURL,
				type: "POST",
				data:{
					"id": id,
					"action": "remove"
				},
				dataType: "json"
			});

			request.done(function(data) {
				console.log("DONE");
				handleRemove($el.find("ul.times"), id);
			});
			request.fail(function(){
				console.log("fail");
			});

		}

		function handleRemove($position, id){
			let field = $("#"+id+"", $position);
			field.remove();
		}
		//inizio funzioni per interagire col db
		function sendTimes($el){
			var type = $el.attr("id");
			let $form = $el.find(".newTimes");
			//var type = $form.parent().attr("id").slice(5);
			var flag = null;
			if (type=="cibo") flag = 0;
			if (type=="uscite") flag = 1;
			$form.find(".time-field").each(function(){
				var time = $(this).val();
				var action = "update";
				var id = $(this).parent().attr("id");
				if(id === undefined)
					action = "insert";			
				
				var request = $.ajax({
					url: options.serverURL,
					type: "POST",
					data: {
						"id": id,
						"time" : time, 
						"flag" : flag,
						"action" : action
					},
					dataType: "json"
				});
				request.done(function(data) {
					handleInsert(data, $el.find('ul.times'));
					handleInsertInPopUp(data, $el.find('form.newTimes'), $el.find('ul.times'));
					console.log("DONE");
				});
				request.fail(function(){
					console.log("fail");
				});

			});
		}

		function loadTimes($el){
			var type = $el.attr("id");
			var flag = null;
			if (type=="cibo") flag = 0;
			if (type=="uscite") flag = 1;
			var request = $.ajax({
				url : options.serverURL,
				type: "POST",
				data:{
					"flag": flag,
					"action" : "load"
				},
				dataType: "json"
			});

			request.done(function(data) {
				handleLoad(data, $el.find('ul.times'));
				handleLoadInPopUp(data, $el.find('form.newTimes'));
			});
	 
			request.fail(function(jqXHR, textStatus) {
				alert( "Request failed: " + textStatus );
			});		
		}

		function handleInsert(data, $position){
			var times = data['times'];
			let html = "";
			if(times.length>0){
				$(times).each(function(index, object){
					html += "<li id="+object['id']+">"+object['time']+"</li>";
					$position.find("li").each(function(){
						var currentId = $(this).attr("id");
						if (currentId == object['id'])
							$(this).remove();
					});
				});
				$position.append(html);
			}
		}

		function handleInsertInPopUp(data, $position, $source) {
			let html = "";
			$position.empty();
			$source.find("li").each(function(){
				var id = $(this).attr("id");
				var value = $(this).text();
				console.log(value);
				html += "<div id="+id+
				 		" class='time'><input class='time-field' type='time' value="+value+
		 				"><button type='button'"+
		 				"class='edit remove'><i class='fa-solid fa-minus'></i></button></div>";
			});
			$position.append(html);

		}

		function handleLoad(data, $position){
			var times = data['times'];
			let html = "";
			if(times.length>0){
				$(times).each(function(index, object){
					html += "<li id="+object['id']+">"+object['time']+"</li>";
				});
				$position.append(html);
			}
		}

		function handleLoadInPopUp(data, $position) {
			var times = data['times'];
			let html = "";

			if(times.length>0){
				$(times).each(function(index, object){
				 	html += "<div id="+object['id']+
				 		" class='time'><input class='time-field' type='time' value="+object['time']+
		 				"><button type='button'"+
		 				"class='edit remove'><i class='fa-solid fa-minus'></i></button></div>";
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
