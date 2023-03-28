document.addEventListener("DOMContentLoaded", () => {
    const modal = document.querySelector("#modal-devices");
    const overlay = document.querySelector('.overlay');
    const addDevice = document.querySelector('#add-device');
    const form = document.querySelector('.newDevice');
    const devices = document.querySelector('.devices');

    $('.device-container button.add').on('click', function(){
        $(modal).addClass('active');
        $(overlay).addClass('active');
    });

    $('#modal-devices button.close-button').on('click', function(){
        $(overlay).removeClass('active');
        $(modal).removeClass('active');
    });

    $(overlay).on('click', function(){
        $(overlay).removeClass('active');
        $(modal).removeClass('active');
    });

    $(addDevice).on('click', function(){
        var elements = form.elements;
        var deviceCredentials = {};

        var elementsArray = Array.from(elements);
        $(elementsArray).each(
            (i, input) => (deviceCredentials[input.name] = input.value)
        );

        var request = $.ajax({
            url: 'server/configureDevice.php',
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

    
function loadDevice(devices){
    var request = $.ajax({
        url: 'server/configureDevice.php',
        type: "POST",
        data: {
            action: "load"
        },
        dataType: "json",
    });

    request.done(function (data) {
        let html = '<a id="'+data['id']+'">'+data['nome']+'</a>';
        console.log(html);
    });
    request.fail(function (){
        console.log('fai schifo');
    });
}
});
