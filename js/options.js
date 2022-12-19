function sendOptionConfiguration(id, state){
    console.log("🚀 ~ file: size.js:16 ~ selectChange ~ impostazione", state);
    var request = $.ajax({
        url: "server/actionsOptions.php",
        type: "POST",
        data: {
          id: id,
          state: state,  
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

