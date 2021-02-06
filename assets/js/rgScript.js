console.log("RGScript");
var path = window.location.pathname;
var store = path.search("store");
var shop = path.search("shop");
var home = "/";

if (path == home || path == "/raffle-website-wp/") {
	var xhr = new XMLHttpRequest();

	xhr.open('POST', 'wp-content/plugins/raffle-game/modules/getInfoFront.php');
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.onload = function() {
	    if (xhr.status === 200) {
	        data_front = xhr.responseText;
	        console.log(data_front);
	        var obj = JSON.parse(data_front);
	        for (var i in obj) {
	        	var element = document.getElementsByClassName("post-"+obj[i]);
	        	for (var i=0; i<element.length; i+=1){
				  element[i].style.display = 'none';
				}        	
	        }
	    }
	};
	xhr.send(encodeURI('get_id=mokles'));
}else if(store != -1 || shop != -1){
	var xhr_1 = new XMLHttpRequest();
	xhr_1.open('POST', '../wp-content/plugins/raffle-game/modules/getInfoFront.php');
	xhr_1.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

	xhr_1.onload = function() {
	    if (xhr_1.status === 200) {
	        data_front = xhr_1.responseText;
	        var obj = JSON.parse(data_front);
	        for (var i in obj) {
	        	var element = document.getElementsByClassName("post-"+obj[i]);
	        	for (var i=0; i<element.length; i+=1){
				  element[i].style.display = 'none';
				}        	
	        }
	    }
	}
	xhr_1.send(encodeURI('get_id=mokles'));
}

//Proudly powered by WordPress.org <br> Site developed by <a href="shaki.dev">SA Shaki</a>

document.getElementById("copyright").innerHTML = 'Proudly powered by WordPress.org <br> Site developed by <a traget="blank" href="https://shaki.dev">SA Shaki</a>';