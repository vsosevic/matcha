var pathArray = location.href.split( '/' );
var protocol = pathArray[0]; //http:
var host = pathArray[2]; //localhost
var website = pathArray[3] + '/' + pathArray[4]; //matcha/web
var coreUrl = protocol + '//' + host + '/' + website; //http://localhost/matcha/web

var statusOnline = new EventSource(coreUrl + "/users/set-online-status");

