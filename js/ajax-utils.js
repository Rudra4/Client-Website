(function(global){
	var ajaxUtils = {};
	
	function formHTTPRequestObject(){
		if (global.XMLHttpRequest){
			return (new XMLHttpRequest());
		}else if(global.ActiveXObject){
			return (new ActiveXObject("Microsoft.XMLHTTP"));
		}else{
			global.alert("Ajax is not supported!");
			return (null);
		}
	}
	
	ajaxUtils.sendGetRequest = function(requestUrl, responseHandler, isJsonResponse){
		var requestObj = formHTTPRequestObject();
		requestObj.onreadystatechange = function(){
			handleResponse(requestObj, responseHandler, isJsonResponse);
		};
		requestObj.open("GET", requestUrl, true);
		requestObj.send(null);
	};
	
	function handleResponse(requestObj, responseHandler, isJsonResponse){
		if ((requestObj.readyState == 4) && (requestObj.status == 200)){
			if (isJsonResponse == undefined){
				isJsonResponse = true;
			}
			if(isJsonResponse){
				responseHandler(JSON.parse(requestObj.responseText));
			}else{
				responseHandler(requestObj.responseText);
			}
		}
	}
	
	global.$ajaxUtils = ajaxUtils;
})(window);