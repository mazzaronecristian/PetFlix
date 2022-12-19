function sendFoodCommand(state) {
  console.log(
    "🚀 ~ file: instant_food.js:2 ~ sendFoodCommand ~ tasto premuto",
    state
  );

  var request = $.ajax({
    url: "server/actionsInstantFood.php",
    type: "POST",
    data: {
      id: 103,
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
