/*const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container");

sign_up_btn.addEventListener('click', () => {
	container.classList.add("sign-up-mode");
});

sign_in_btn.addEventListener('click', () => {
	container.classList.remove("sign-up-mode");
});*/

//START POP-UP SCRIPT
(function($){
	console.log("jQuery: " +$);
	$.fn.todo = function(){

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
			
			for (var i = 0; i < input.length; i++) {
				html += '<li>'+$form.find(input[i]).val()+'</li>';
			}

			let $times = $el.find('ul.times');
			$times.append(html);

		}

	}
})(jQuery);

jQuery(document).ready(function(){
	console.log("READY");
	jQuery(".sezioneOrari").todo();
});

function closeField(button){
	let field = button.closest('.time')
	field.remove()
}
//END SCRIPT FOR POP-UP




//START NAVBAR SCRIP
	const food_btn = document.getElementById("food-btn");
	const health_btn = document.getElementById("health-btn");
	const health_info = document.querySelector("#health-info");
	const food_info = document.querySelector("#food-info")

	health_btn.addEventListener('click', ()=>{
		health_info.classList.add("info-active");
		health_info.classList.remove("avoid-clicks");
		food_info.classList.remove("info-active");
		food_info.classList.add("avoid-clicks");
	});


	food_btn.addEventListener('click', ()=>{
		food_info.classList.add("info-active");
		food_info.classList.remove("avoid-clicks");
		health_info.classList.remove("info-active");
		health_info.classList.add("avoid-clicks");
	});

//END NAVBAR SCRIPT

//START PLOT SCRIPT
var values = [0];
var labels = [0];

function pickAndPlotValues(idValue, idLabel) {
	let field_value = document.getElementById(idValue);
	let field_label = document.getElementById(idLabel);
	console.log(field_label.value);

	if(field_value.value != "" && field_label.value != "") {
		if (values[0]==0) 
			values[0] = field_value.value;
		else 
			values.push(eval(field_value.value));
		if(labels[0] == 0) 
			labels[0] = field_label.value;
		else 
			labels.push(field_label.value);
		
		new Chart("plotPeso", {
		  type: "line",
		  data: {
		    labels: labels,
		    datasets: [{
		      data: values,
		      borderColor: "#577590",
		      fill: false
		    }]
		  },
		  options: {
		    legend: {display: false}
		  }
		});
	}
	else return;
}
//END PLOT SCRIPT