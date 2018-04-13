
$.please = function (time) {
    $.blockUI({ css: { 
        border: 'none', 
        padding: '15px', 
        backgroundColor: '#000', 
        '-webkit-border-radius': '10px', 
        '-moz-border-radius': '10px', 
        opacity: .5, 
        color: '#FFFFFF' 
    } }); 

    setTimeout($.unblockUI, time);
}

$.open_pdf = function (url) {
    $.fancybox.open({padding: 0, href: url, type: 'iframe', width: 2000, height: 1024, });
}

$.sonido = function (mensaje) {
    ion.sound({
        sounds: [
            {name: mensaje}
        ],
        path: base_url()+"/assets/sound/",
        preload: true,
        volume: 1.0
    });
}

/*$.search_id = function (url, data_send, callbackFnk) {
    $.get(url, data_send, function (data) {
        if (typeof callbackFnk == 'function') {
            callbackFnk.call(this, data);
        }
    });
}*/

$.extend({
    search_id: function(url, param) {
        // local var
        var theResponse = null;
        // jQuery ajax
        $.ajax({
            url: url,
            type: 'GET',
            data: {'param': param},
            dataType: "json",
            async: false,
            success: function(respText) {
                theResponse = respText;
            }
        });
        // Return the response text
        return theResponse;
    }
});