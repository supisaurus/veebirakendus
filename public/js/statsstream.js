

function dataRetrival() {	
	if(typeof(EventSource) !== "undefined") {	
		//var e = document.getElementById("valik");
		//var querySetting = e.options[e.selectedIndex].value;
		var source = new EventSource("/data/Kandidaat");		
		source.onmessage = function(event) {
			document.getElementById("result").innerText = event.data;						
		};
		 
	}
	else {
		document.getElementById("result").innerText = "Sorry, your browser does not support server-sent events...";
		var myRequest = new XMLHttpRequest();
		myRequest.open("GET", "/data/Kandidaat", true);
		myRequest.onreadystatechange = responseAjax;
        myRequest.setRequestHeader("Cache-Control", "no-cache");
		myRequest.send(null);
	}
}

function responseAjax() {
     if(myRequest.readyState == 4) {
        if(myRequest.status == 200) {
            result = myRequest.responseText;
            alert(result);
            alert("we made it");
        } else {
            alert( " An error has occurred: " + myRequest.statusText);
        }
     }
  }
  
 function statsRetrival(str) {
    if (str == "") {
        document.getElementById("valik").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("result").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","/data2/"+str,true);
        xmlhttp.send();
    }
} 