document.addEventListener("DOMContentLoaded", () => {
    const addDevice = document.querySelector('#add-device');
    const form = document.querySelector('.newDevice');
    const devices = document.querySelector('.devices');

    $(addDevice).on('click', function(){
        var elements = form.elements;
        var deviceCredentials = {};

        var elementsArray = Array.from(elements);
        $(elementsArray).each(
            (i, input) => (deviceCredentials[input.name] = input.value)
        );

        var request = $.ajax({
            url: 'server/device.php',
            type: "POST",
            data: {
                nome: deviceCredentials["nome"],
                id: deviceCredentials["id"],
                action: "insert"
            },
            dataType: "json",
        });

        request.done(function (data) {
            if (!data) alert("Errore di inserimento della scheda");
            else{
                alert("scheda inserita con successo");
                window.location.href = "index.php";
            }
        });
    });


    loadDevice(devices);

    
function loadDevice(location){
    var request = $.ajax({
        url: 'server/device.php',
        type: "POST",
        data: {
            action: "load"
        },
        dataType: "json",
    });

    request.done(function (data) {
        let devices = data['devices'];
        let html = '';
        $(devices).each(function (index, object) {
            html += '<a class="device" id="'+object['id']+'">'+object['nome']+'</a>';
          });
        $(location).append(html);
    });
    request.fail(function (){
        console.log('fai schifo');
    });
}
});
