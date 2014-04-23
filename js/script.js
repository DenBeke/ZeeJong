/*
Basic Script for Betting System

Created: February 2014
*/


$(document).ready(function(){



	$('.wiki').each(function(){
		
		var element = this;
		var jsonUrl = $(this).attr('data-wiki');
		 	
		 //Retrieve JSON object and load data	
		 $.getJSON(jsonUrl, function(data) {	
			
			//Check for errors
			if(data['error'] == null) {
			
				//$(this).html(data['wiki']);
				$(element).html(data['wiki']);
	
			}
			else {
				
				$(this).html('Could not load wiki');
				
			}
		
		});
	});






	$('.news-button a').click(function(){
		
		//alert("test" + this.getAttribute("data-id"));
		
		
		$('.active').removeClass('active');
		$(this).parent('li').addClass('active');
		
		$('#news-feed').html("loading...");
		
		
		
		var jsonUrl = $(this).attr('data-json');
		 	
		 //Retrieve JSON object and load data	
		 $.getJSON(jsonUrl, function(data) {
		 	
			
			//Check for exif data, and load the data if needed.
			
			
			//Do action when image is loaded
			/*
			$('#lightboxContent #photo').load(function() {
				
				$('#overlay .loading').removeClass('active');
				$('#lightboxContent #photo').fadeIn();
				
				
			});
			*/
			
			
			//Check for errors
			if(data['error'] == null) {
				
				$('#news-feed').html('');
				
				//loop through the feed items
				data.forEach(function(data) {
					
					var item = '<div class="chunk">\
						<div class="panel panel-default">\
							<div class="panel-heading">\
								<h3 class="panel-title"><a href="' + data.url + '">' + data.title + '</a></h3>\
							</div>\
							<div class="panel-body">' + data.content + '</div>\
							<div class="panel-footer rss-footer">' + data.date + '</div>\
						</div>\
					</div>';
					
					$('#news-feed').append(item);
				
				});
				
				
			}
			else {
				
				$('#news-feed').html('Could not load feed');
				
			}
		
				
		 });
		
		
	});

});