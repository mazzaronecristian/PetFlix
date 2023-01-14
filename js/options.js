function sendOptionConfiguration(id, state){
    console.log("🚀 ~ file: size.js:16 ~ selectChange ~ impostazione", state);
    var request = $.ajax({
        url: "server/actionsOptions.php",
        type: "POST",
        data: {
          id: id,
          state: state,  
          action: "insert"
        },
        dataType: "json",
      });
      request.done(function (data) {
        console.log("DONE");
      });
      request.fail(function () {
        console.log("fail");
      });
}

(function($){
  $.fn.options = function(server){
    var defaults = {
      serverURL: "example.com/server_page_url",
    };
    server = $.extend(defaults, server);

    return this.each(function(i, obj){
      this.addEventListener("click",() =>{
        sendOption($(this).attr("id"),this.checked);
      });
      
      loadOptions(this);
    });

    function loadOptions(item){
      id = $(item).attr("id");
      var request = $.ajax({
        url: server.serverURL,
        type: "POST",
        data:{
          id: id,
          action: "load"
        },
        dataType: "json"
      });
      request.done(function (data) {
        console.log("🚀 ~ file: options.js:46 ~ data", data);
        handleLoad(data, item);
      });
      request.fail(function () {
        console.log("fail");
      });
    }

    function sendOption(id, state){
      console.log("🚀 ~ file: size.js:16 ~ selectChange ~ impostazione", state);
      state = state ? 1 : 0;
      var request = $.ajax({
          url: server.serverURL,
          type: "POST",
          data: {
            id: id,
            state: state,  
            action: "insert"

          },
          dataType: "json",
        });
        request.done(function (data) {
          console.log("DONE");
        });
        request.fail(function () {
          console.log("fail");
        });
    }

    function handleLoad(data, item) {
      var state = data['state'];
      item.checked = state==1 ? true : false;
      /*if(state == 1)
        item.checked = true;
      else if(state == 0 )
        item.checked = false;*/
    }
  }
})(jQuery);



