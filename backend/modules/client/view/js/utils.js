function amigable(url) {
    var link = "";
    var aux = "";
    url = url.replace("?", "");
    url = url.split("&");
    cont = 0;
    for ( var i=0; i < url.length; i++ ) {
    	cont++;
        aux = url[i].split("=");
        if (cont == 2) {
        	link +=  "/"+aux[1];	
        } else{
        	link =  "/"+aux[1];
        }
    }
    return "http://localhost/framework-php" + link;
}