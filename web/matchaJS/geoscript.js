var x = document.getElementById("demo");

var xmlhttp = new XMLHttpRequest();

xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    	x.innerHTML = this.responseText;
    }
}

if (navigator.geolocation) {
    // navigator.geolocation.getCurrentPosition(showPosition);
    navigator.geolocation.getCurrentPosition(getPosition);
    function getPosition(position) {
	    var latitude = position.coords.latitude; 
	    var longitude = position.coords.longitude;
        xmlhttp.open("GET", "save-city?latitude=" + latitude + "&longitude=" + longitude, true);
        xmlhttp.send();
	}
} else { 
    x.innerHTML = "Geolocation is not supported by this browser.";
}