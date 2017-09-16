var pathArray = location.href.split( '/' );
var protocol = pathArray[0]; //http:
var host = pathArray[2]; //localhost
var website = pathArray[3] + '/' + pathArray[4]; //matcha/web
var coreUrl = protocol + '//' + host + '/' + website; //http://localhost/matcha/web

$( document ).ready(function() {

  // $('#like').on('click', function(){
  //   console.log('like');
  // });

  $(document).on('click', '.like', function(e){
    var likeId = this.id;
    var url = coreUrl + "/users/like";
    $.ajax({
       type: "POST",
       url: url,
       data: { likeUserId: this.id },
       success: function(responseData)
       {
            // var jsonResponse =  JSON.parse(responseData);
            console.log(".like, #" + likeId);
            $("[id=" + likeId + "]").toggle();
       }
    });
  });

  $(document).on('click', '.unlike', function(e){
    var likeId = this.id;
    var url = coreUrl + "/users/unlike";
    $.ajax({
       type: "POST",
       url: url,
       data: { likeUserId: this.id },
       success: function(responseData)
       {
            // var jsonResponse =  JSON.parse(responseData);
            console.log(".unlike, #" + likeId);
            $("[id=" + likeId + "]").toggle();
       }
    });
  });

});

function revert(id) {

  if ($(this).css('display') === 'none') {
    x.style.display = 'inline';
  } else {
    x.style.display = 'none';
  }

  // var x = document.getElementById(id);
  // if (x.style.display === 'none') {
  //   x.style.display = 'inline';
  // } else {
  //   x.style.display = 'none';
  // }
}