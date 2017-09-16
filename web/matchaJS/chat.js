var pathArray = location.href.split( '/' );
var protocol = pathArray[0]; //http:
var host = pathArray[2]; //localhost
var website = pathArray[3] + '/' + pathArray[4]; //matcha/web
var coreUrl = protocol + '//' + host + '/' + website; //http://localhost/matcha/web

var chatWith = window.location.href.substr(window.location.href.lastIndexOf('/') + 1);

var me = {};
// me.avatar = coreUrl + "/uploads/1.jpg";

var you = {};
// you.avatar = coreUrl + "/uploads/595107ad2e579.png";



function formatAMPM(date) {
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0'+minutes : minutes;
    var strTime = hours + ':' + minutes + ' ' + ampm;
    return strTime;
}            

//-- No use time. It is a javaScript effect.
function insertChat(who, text, time = 0, date = 0){
    var control = "";
    if (date == 0) {
        var date = formatAMPM(new Date());
    }
    
    if (who == "me"){
        
        control = '<li style="width:100%">' +
                        '<div class="msj macro">' +
                        '<div class="avatar"><img class="img-circle" style="width:100%;" src="'+ me.avatar +'" /></div>' +
                            '<div class="text text-l">' +
                                '<p>'+ text +'</p>' +
                                '<p><small>'+date+'</small></p>' +
                            '</div>' +
                        '</div>' +
                    '</li>';                    
    }else{
        control = '<li style="width:100%;">' +
                        '<div class="msj-rta macro">' +
                            '<div class="text text-r">' +
                                '<p>'+text+'</p>' +
                                '<p><small>'+date+'</small></p>' +
                            '</div>' +
                        '<div class="avatar" style="padding:0px 0px 0px 10px !important"><img class="img-circle" style="width:100%;" src="'+you.avatar+'" /></div>' +                                
                  '</li>';
    }
    setTimeout(
        function(){                        
            $(".chat-ul").append(control);

        }, time);
    
}

function resetChat(){
    $(".chat-ul").empty();
}

$(".mytext").on("keyup", function(e){
    if (e.which == 13){
        var text = $(this).val();
        if (text !== ""){
            insertChat("me", text, 0 , 0);              
            $(this).val('');

        }

        var url = coreUrl + "/chat/send-message";
        $.ajax({
           type: "POST",
           url: url,
           data: { message: text, chatWith: chatWith },
           success: function(responseData)
           {
                var jsonResponse =  JSON.parse(responseData);
                console.log(responseData);
           }
        });
    }
});

//-- Clear Chat
resetChat();

window.onload = function() {

    var urlAvatars = coreUrl + "/chat/get-avatars-for-chat";
    $.ajax({
       type: "POST",
       url: urlAvatars,
       data: { chatWith: chatWith },
       success: function(responseData)
       {
            var jsonResponse =  JSON.parse(responseData);

            me.avatar = coreUrl + '/' + jsonResponse.me;
            you.avatar = coreUrl + '/' + jsonResponse.you;
       }
    });

    var url = coreUrl + "/chat/get-message-history";
    $.ajax({
           type: "POST",
           url: url,
           data: { data: chatWith },
           success: function(responseData)
           {
                // console.log(responseData);
                var jsonResponse =  JSON.parse(responseData);

                for(var k in jsonResponse) {
                    if (jsonResponse[k].writtenBy == 'me') {
                        insertChat("me", jsonResponse[k].message, k*100, jsonResponse[k].date);
                    } else {
                        insertChat("you", jsonResponse[k].message, k*100, jsonResponse[k].date);
                    }
                }
           }
         });

}

setTimeout(
    function(){
        var source = new EventSource(coreUrl + "/chat/get-new-message?chatWith=" + chatWith);
        source.onmessage = function(event) {
            if (event.data) {
                insertChat("you", event.data, 0);
            }
        };

        var status = new EventSource(coreUrl + "/users/get-online-status?chatWith=" + chatWith);
        status.onmessage = function(event) {
            if (event.data) {
              $('.online-status').text(event.data);
            }
        };

        var statusOnline = new EventSource(coreUrl + "/users/set-online-status");

    }, 3000);



