var pathArray = location.href.split( '/' );
var protocol = pathArray[0]; //http:
var host = pathArray[2]; //localhost
var website = pathArray[3] + '/' + pathArray[4]; //matcha/web
var coreUrl = protocol + '//' + host + '/' + website; //http://localhost/matcha/web

var visitiedProfile = window.location.href.substr(window.location.href.lastIndexOf('/') + 1);

$( document ).ready(function() {
  var status = new EventSource(coreUrl + "/users/get-online-status?user=" + visitiedProfile);
  status.onmessage = function(event) {
    if (event.data) {
      $('.online-status').text(event.data);
    }
  };
});

