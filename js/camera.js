(function () {

 var streaming = false;
 video = document.getElementById('video');
 cover = document.getElementById('cover');
 canvas = document.getElementById('canvas');
 photo = document.getElementById('photo');
 montage = document.getElementById('montage-done');
 test = document.getElementById('test');
 startbutton = document.getElementById('startbutton');
 deletebutton = document.getElementById('deletebutton');
 finish = document.getElementById('finish');
 width = 700;
 height = 220;

 navigator.getMedia = (navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia);

 navigator.getMedia({
video: true,
audio: false
},
function (stream) {
if (navigator.mozGetUserMedia) {
video.mozSrcObject = stream;
}
else {
var vendorURL = window.URL || window.webkitURL;
video.src = vendorURL.createObjectURL(stream);
}
video.play();
},
function (err) {
console.log("An error occured! " + err);
}
);

 video.addEventListener('canplay', function (ev) {
		 if (!streaming) {
		 height = video.videoHeight / (video.videoWidth / width);
		 video.setAttribute('width', width);
		 video.setAttribute('height', height);
		 canvas.setAttribute('width', width);
		 canvas.setAttribute('height', height);
		 streaming = true;
		 }
		 }, false);

function takepicture() {

	canvas.width = width;
	canvas.height = height;
	var ctx = canvas.getContext('2d');
	ctx.translate(width, 0);
	ctx.scale(-1, 1);
	ctx.drawImage(video, 0, 0, width, height);
	var data = canvas.toDataURL('image/png');
}

startbutton.addEventListener('click', function (ev) {
		takepicture();
		document.getElementById("video").setAttribute("style", "display:none");
		document.getElementById("canvas").setAttribute("style", "display:block");
		document.getElementById("photo").setAttribute("style", "display:none");
		ev.preventDefault();
		}, false);
})();

function previewFile() {

	var preview = document.getElementById('photo');
	var file = document.querySelector('input[type=file]').files[0];
	var reader = new FileReader();
	var check_montage = document.getElementById("montage-done").getAttribute("style");

	reader.addEventListener("load", function () {
			preview.src = reader.result;
			}, false);

	if (file && check_montage == "display:none") {
		reader.readAsDataURL(file);
		document.getElementById("canvas").setAttribute("style", "display:none");
		document.getElementById("video").setAttribute("style", "display:none");
		document.getElementById("photo").setAttribute("style", "display:block");
	}
}

function save() {

	test = document.getElementById("test");
	finish = document.getElementById('finish'),
		   finish.addEventListener('click', 
				   function (ev) {
				   var data = canvas.toDataURL('image/png');
				   var data_img = photo.getAttribute('src');
				   var check = document.getElementById("video").getAttribute("style");
				   var check_img = document.getElementById("photo").getAttribute("style");
				   var check_canvas = document.getElementById("canvas").getAttribute("style")

				   if (check_canvas == "display:block") {
				   test.setAttribute('value', data);
				   }
				   else if (check_img == "display:block") {
				   test.setAttribute('value', data_img);
				   }
				   document.getElementById("photo").setAttribute("src", "./script/image.php");
				   setTimeout(document.getElementById('zdp').submit(), 40);
				   }, false);
}
