function openModal(content, timeThisContent, showconditions, contenttype, clickDo, clickDoEl){
	//если раз в сутки
	if(showconditions == 1){ // если раз в сутки
		if($.cookie(content)){}
	    else{
	    	if(contenttype == "image"){
		        setTimeout(function(){
				  			$.fancybox.open([
					        	{
					        		src  : content,
					        		buttons: ['close'],
					        		afterShow: function( instance, slide ) {
					        			$(document).on("click", "img[src='"+content+"']", function(){
					        				popupClick(clickDo, clickDoEl);
					        			})
					        		}	        		
					        	}
					        ]);
				  	}, timeThisContent);
		        	$.cookie(content, true, {expires: 1});
		    	}
		    	else if(contenttype == "inline"){
		        setTimeout(function(){
				  			$.fancybox.open([
					        	{
					        		src  : content,
					        		type : 'inline',
					        		afterShow: function( instance, slide ) {
				        			$(document).on("click", content, function(){
					        				if(clickDo == "nothing"){}
					        					else					        					
						        				popupClick(clickDo, clickDoEl);
					        			})
					        		}	        		
					        	}
					        ]);
				  	}, timeThisContent);
		        	$.cookie(content, true, {expires: 1});
		    	}
	    	}
	} else{
		if(contenttype == 'image'){
       setTimeout(function(){
			  		$.fancybox.open([
				        	{
				        		src  : content,
				        		buttons: ['close'],
				        		afterShow: function( instance, slide ) {
				        			$(document).on("click", "img[src='"+content+"']", function(){
				        				popupClick(clickDo, clickDoEl);
				        			})
				        		}
				        	}
				        ]);
			  		}, timeThisContent);
      	}
      	else if(contenttype == 'inline'){
		       setTimeout(function(){
					  		$.fancybox.open([
						        	{
						        		src  : content,
						        		type : 'inline',
						        		afterShow: function( instance, slide ) {
					        			$(document).on("click", content, function(){
					        					if(clickDo == "nothing"){}
					        					else					        					
						        				popupClick(clickDo, clickDoEl);
						        			})
						        		}

						        	}
						        ]);
					  		}, timeThisContent);
		      	}
	}// end else    
}
//
function clickModal(element, content, contenttype){
	$(document).on("click", element, function(){
		if(contenttype == 'image'){
			  $.fancybox.open([
				{
					src  : content
				}
			]);
		}
		else if(contenttype == 'inline'){
			  $.fancybox.open([
				{
					src  : content,
					type : 'inline'
				}
			]);
		}
	})
}

function popupClick(clickDo, clickDoEl){
	$.fancybox.close();
	if(clickDo == "link"){
		location.href = clickDoEl;
	}else if(clickDo == "scroll"){
		jQuery.scrollTo(clickDoEl, 500);
	}
}


$.post(document.location.href, {action: 'getpopup'}, function(data) {
	//alert(data);
	var res = JSON.parse(data);

	console.log(res);
	//console.log(res['chunk']);
	for (i=0; i<res.length; i++) {
		
		var content = res[i]['chunk'];
		var showconditions = res[i]['showcondition'];
		var eventContent = res[i]['event'];
		var clickDo = res[i]['clickdo'];
		var clickDoEl = res[i]['clickdoelement'];

		  
		  	if( eventContent == 'time' ){
		  		// время показа баннера
		  		var timeContent = res[i]['showtime'];
		  		// показываем
		  		if(res[i]['type'] == 'image'){ setTimeout(openModal(content, timeContent, showconditions, contenttype='image', clickDo, clickDoEl)); }
		  		if(res[i]['type'] == 'inline'){ setTimeout(openModal(content, timeContent, showconditions, contenttype='inline', clickDo, clickDoEl)); }		  		
		  	}

		  	if( eventContent == 'click' ){
		  		var clickel = res[i]['clickelement'];

		  		if(res[i]['type'] == 'image'){ clickModal(clickel, content, contenttype="image", clickDo, clickDoEl); }
		  		if(res[i]['type'] == 'inline'){ clickModal(clickel, content, contenttype="inline", clickDo, clickDoEl); }
		  		
		  	}

		 }
	});

