
var base_url = function(path) {
    var protocolo = location.protocol;
    var base = window.location.host;

    // var ur = base.replace(/(.*)\.(.*?)$/, "$1");
    var url  = base;
    if(path !== undefined){
        url = url+path;
    }
    url = protocolo+'//'+url
    return url;
};

var assets_url = function(path){
    var url  = (path !== undefined)? base_url('/')+path:base_url('/assets/') ;
    return url;
};



