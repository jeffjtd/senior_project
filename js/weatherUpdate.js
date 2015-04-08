function weatherUpdate(){
	$.ajax({
		url : "http://weather.yahooapis.com/forecastrss?p=32612", 
		type: "GET",
		datatype: "XML",
		success: function(data)
		{
			// alert("I'm here");
			// console.log(data);

		}
	});

}
/*
on click submit button > store location value in a variable js
$.ajax() {
	url : weather 
	action get;

}
do an ajax call to the yahoo api
parse the return data into an array

 .done(function( data ) {
	console.log(data);
	change your DOM elements to the data
	document.getElementID('sanjayID').text ..
});



*/