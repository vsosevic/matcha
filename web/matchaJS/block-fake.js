var pathArray = location.href.split( '/' );
var protocol = pathArray[0]; //http:
var host = pathArray[2]; //localhost
var website = pathArray[3] + '/' + pathArray[4]; //matcha/web
var coreUrl = protocol + '//' + host + '/' + website; //http://localhost/matcha/web

$( document ).ready(function() {

  $(document).on('click', '.block', function(e){
    var blockId = this.id;
    var url = coreUrl + "/users/block";
    $.ajax({
       type: "POST",
       url: url,
       data: { blockUserId: this.id },
       success: function(responseData)
       {
            $("[id=" + blockId + "]").toggle();
       }
    });
  });

  $(document).on('click', '.unblock', function(e){
    var blockId = this.id;
    var url = coreUrl + "/users/unblock";
    $.ajax({
       type: "POST",
       url: url,
       data: { blockUserId: this.id },
       success: function(responseData)
       {
            $("[id=" + blockId + "]").toggle();
       }
    });
  });

    $(document).on('click', '.fake', function(e){
        var fakeId = this.id;
        var url = coreUrl + "/users/fake";
        $.ajax({
            type: "POST",
            url: url,
            data: { fakeUserId: this.id },
            success: function(responseData)
            {
                alert('You\'ve successfully reported about fake account. Thank you!' );
            }
        });
    });

});
