(function ($) {
  $.fn.plot = function (server) {
    var defaults = {
      serverURL: "example.com/server_page_url",
    };
    server = $.extend(defaults, server);



    return this.each(function (i, obj) {
      let $this = $(this);
      let $canvas = $("#plotPeso", $this);
      let $button = $("button.invio-peso", $this);

      $button.on("click", function () {
        let weight = $this.find(".nuovoPeso").val();
        let date = $this.find(".nuovaData").val();

        sendWeights(date, weight);
      });

      loadWeights();
    });

    function loadWeights() {
      var request = $.ajax({
        url: server.serverURL,
        type: "POST",
        data: {
          action: "load",
        },
        dataType: "json",
      });
      request.done(function (data) {
        console.log("DONE");
        handleInsert(data);
      });
      request.fail(function () {
        console.log("fail");
      });
    }

    function sendWeights(date, weight) {
      console.log(
        "🚀 ~ file: plot.js:22 ~ sendWeight ~ date, weight",
        date,
        weight
      );

      var request = $.ajax({
        url: server.serverURL,
        type: "POST",
        data: {
          weight: weight,
          date: date,
          action: "insert",
        },
        dataType: "json",
      });
      request.done(function (data) {
        console.log("DONE");
        handleInsert(data);
      });
      request.fail(function () {
        console.log("fail");
      });
    }

    function handleInsert(data) {
      var weights = data["weights"];
      var values = [];
      var labels = [];
      console.log("🚀 ~ file: plot.js:52 ~ handleInsert ~ weights", weights);
      $(weights).each(function (index, object) {
        values.push(eval(object["weight"]));
        labels.push(object["date"]);
      });

      new Chart("plotPeso", {
        type: "line",
        data: {
          labels: labels,
          datasets: [
            {
              data: values,
              borderColor: "#577590",
              fill: false,
            },
          ],
        },
        options: {
          legend: { display: false },
        },
      });
    }
  };
})(jQuery);
