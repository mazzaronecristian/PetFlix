function selectChange(value){
    console.log("🚀 ~ file: size.js:16 ~ selectChange ~ funziona!!", value);
    var request = $.ajax({
        url: "server/actionsSize.php",
        type: "POST",
        data: {
          id: 1234,
          description: "taglia",
          state: value,  
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

