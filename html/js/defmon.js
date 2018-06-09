function loadD() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) { 
      var para = document.createElement("p");
	var node = document.createElementNS(this.responseText);
	para.appendChild(node);
	var element = document.getElementById("demo");
	element.appendChild(para);
    }
  };
  xhttp.open("GET", "tcharts.php", true);
  xhttp.send();
}

function loadDoc() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) { 
	var element = document.getElementById("mbody").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "dominios.php", true);
  xhttp.send();
}

function loadDoc1() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) { 
	var element = document.getElementById("mainbody").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "charts.php", true);
  xhttp.send();
}

function loadDoc4() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) { 
	var element = document.getElementById("mbody").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "clasificacion.php", true);
  xhttp.send();
}

function algo(caller) {
	console.log(Object.getOwnPropertyNames(caller))
	console.log(caller.innerHTML)
}

function loadDocn(caller) {
	var dom = caller.innerHTML;
	var payload = "dom=hola"
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) { 
		var element = document.getElementById("mbody").innerHTML = this.responseText;
		console.log(payload);
		}
	};
	xhttp.open('POST', "stats.php", true);
	xhttp.send(payload);
}



function send2(){
var req = new XMLHttpRequest();
req.open('POST', 'stats.php', true);
var params = 'dom=paste&api_paste_private=0&api_dev_key=8845011a5df258653d18960505777f27&api_paste_code=holaaa';
req.send(params);
console.log(req.responseText)
req.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) { 
		var element = document.getElementById("mbody").innerHTML = this.responseText;
		}
	};

}

function testDoc(){
var xhr = new XMLHttpRequest();
xhr.open('GET', 'server.php', true);
xhr.onload = function () {
	var element = document.getElementById("mbody").innerHTML = this.responseText
};
xhr.send('ip=ip');
}
