var pathArray = location.href.split( '/' );
var protocol = pathArray[0]; //http:
var host = pathArray[2]; //localhost
var website = pathArray[3] + '/' + pathArray[4]; //matcha/web
var coreUrl = protocol + '//' + host + '/' + website; //http://localhost/matcha/web

$( document ).ready(function() {

    var notifications = new EventSource(coreUrl + "/site/get-notifications");
    notifications.onmessage = function(event) {
        if (event.data) {
            if (event.data > 0) {
                $('.notifications a').html('Notifications <span class="badge">' + event.data + '</span>');
                console.log(event.data);
            }
        }
    };

    var chat_notifications = new EventSource(coreUrl + "/site/get-chat-notifications");
    chat_notifications.onmessage = function(event) {
        if (event.data) {
            if (event.data > 0) {
                $('.chat a').html('Chat <span class="badge">' + event.data + '</span>');
                console.log(event.data);
            }
        }
    };

});

