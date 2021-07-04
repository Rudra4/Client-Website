$(
	function(){
		$("#navbarToggle").blur(function(event){
			var screenWidth = window.innerWidth;
			if(screenWidth < 768){
				$("#collapsable-nav").collapse('hide');
			}
		});
	}
);

(function(global){
	var nameSpace = {};
	var homeHtmlUrl = "snippets/home-snippet.html";
	var catDataUrl = "data/categories.json";
	var catTitleHtml = "snippets/categories-title-snippet.html";
	var catHtml = "snippets/category-snippet.html";
	var catItemsUrl = "data/";
	var catItemsTitleHtml = "snippets/category-items-title-snippet.html";
	var catItemHtml = "snippets/category-item-snippet.html";
	var formHtmlUrl = "snippets/form-snippet.html";
	var loginHtmlUrl = "snippets/login-snippet.html";
	
	var insertHtml = function(selector, html){
		var targetElement = document.querySelector(selector);
		targetElement.innerHTML = html;
	};
	
	var showLoadIcon = function(selector){
		var html = "<div class = 'text-center'><img src = 'images/ajax-loader.gif></div>'";
		insertHtml(selector, html);
	};
	
	var insertProperty = function(string, propName, propValue){
		var propToReplace = "{{" + propName + "}}";
		string = string.replace(new RegExp(propToReplace, "g"), propValue);
		return string;
	};
	
	var switchProgToActive = function(){
		var classes = document.querySelector("#navHomeButton").className;
		classes = classes.replace(new RegExp("active", "g"), "");
		document.querySelector("#navHomeButton").className = classes;
		
		classes = document.querySelector("#navProgButton").className;
		if(classes.indexOf("active") == -1){
			classes += " active";
		}
		document.querySelector("#navProgButton").className = classes;
	};
	
	document.addEventListener("DOMContentLoaded", function(event){
		showLoadIcon("#main-content");
		$ajaxUtils.sendGetRequest(homeHtmlUrl, function(responseText){
			document.querySelector("#main-content").innerHTML = responseText;
		}, false);
	});
	
	nameSpace.loadProgramCategories = function(){
		showLoadIcon("#main-content");
		$ajaxUtils.sendGetRequest(catDataUrl, buildAndShowCategoriesHtml);
	};
	
	nameSpace.loadCamps = function(){
		showLoadIcon("#main-content");
		insertHtml("#main-content", "<h2 id = 'camph2'>We will be back with some exciting camps soon! <span class = 'myBlink'>Stay Tuned!</span></h2>");
	};
	
	nameSpace.loadAbout = function(){
		showLoadIcon("#main-content");
		insertHtml("#main-content", "<h1 id = 'abouth1'>About Us!</h1>" + "<img class='img-responsive imgcenter' src='images/preamble.jpg' alt='Preamble'>");
	};
	
	nameSpace.loadCategoryItems = function(categoryShort){
		showLoadIcon("#main-content");
		$ajaxUtils.sendGetRequest(catItemsUrl + categoryShort + ".json", buildAndShowCatItemsHtml);
	};
	
	nameSpace.loadForm = function(){
		showLoadIcon("#main-content");
		$ajaxUtils.sendGetRequest(formHtmlUrl, function(responseText){
			document.querySelector("#main-content").innerHTML = responseText;
		}, false);
	};
	
	nameSpace.doRequireCb = function () {
            cb=document.getElementsByClassName("acb");

            var atLeastOneChecked=false;//at least one cb is checked
            for (i=0; i<cb.length; i++) {
                if (cb[i].checked === true) {
                    atLeastOneChecked=true;
                }
            }

            if (atLeastOneChecked === true) {
                for (i=0; i<cb.length; i++) {
                    cb[i].required = false;
                }
            } else {
                for (i=0; i<cb.length; i++) {
                    cb[i].required = true;
                }
            }
        };

	nameSpace.loginPage = function(){
		showLoadIcon("#main-content");
		$ajaxUtils.sendGetRequest(loginHtmlUrl, function(responseText){
			document.querySelector("#main-content").innerHTML = responseText;
		}, false);
	};
	
	function buildAndShowCategoriesHtml(categories){
		$ajaxUtils.sendGetRequest(catTitleHtml, function(catTitleHtml){
			$ajaxUtils.sendGetRequest(catHtml, function(catHtml){
				switchProgToActive();
				var catViewHtml = buildCategoriesViewHtml(categories, catTitleHtml, catHtml);
				insertHtml("#main-content", catViewHtml);
			}, false);
		}, false);
	}
	
	function buildCategoriesViewHtml(categories, catTitleHtml, catHtml){
		var finalHtml = catTitleHtml + "<section class = 'row'>";
		for(var i = 0; i < categories.length; i++){
			var html = catHtml;
			var name = "" + categories[i].name;
			var short_name = categories[i].short_name;
			html = insertProperty(html, "name", name);
			html = insertProperty(html, "short_name", short_name);
			finalHtml += html;
		}
		finalHtml += "</section>";
		return finalHtml;
	}
	
	function buildAndShowCatItemsHtml(categoryItems){
		$ajaxUtils.sendGetRequest(catItemsTitleHtml, function(catItemsTitleHtml){
			$ajaxUtils.sendGetRequest(catItemHtml, function(catItemHtml){
				switchProgToActive();
				var catItemsViewHtml = buildCatItemsViewHtml(categoryItems, catItemsTitleHtml, catItemHtml);
				insertHtml("#main-content", catItemsViewHtml);
			}, false);
		}, false);
	}
	
	function buildCatItemsViewHtml(categoryItems, catItemsTitleHtml, catItemHtml){
		catItemsTitleHtml = insertProperty(catItemsTitleHtml, "name", categoryItems.name);
		catItemsTitleHtml = insertProperty(catItemsTitleHtml, "first_name", categoryItems.first_name);
		catItemsTitleHtml = insertProperty(catItemsTitleHtml, "last_name", categoryItems.last_name);
		catItemHtml = insertProperty(catItemHtml, "short_name", categoryItems.short_name);
		var finalHtml = catItemsTitleHtml + "<section class = 'row'>";
		var catComp = categoryItems.components;
		for(var i = 0; i < catComp.length; i++){
			var html = catItemHtml;
			var cName = catComp[i].cName;
			var cShort = catComp[i].cShort;
			var content = catComp[i].content;
			html = insertProperty(html, "cName", cName);
			html = insertProperty(html, "cShort", cShort);
			html = insertProperty(html, "content", content);
			finalHtml += html;
		}
		finalHtml += "</section>";
		return finalHtml;
	}
	
	function buildAndShowFormHtml(formHtml){
		insertHtml("#main-content", form);
	}
	
	global.$nameSpace = nameSpace;
})(window);