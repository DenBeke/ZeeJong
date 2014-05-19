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
	
	
	
	$('.hidden-click').click(function(){
		
		
		if ($(this).next('.hidden-content').hasClass('open')) {
			$(this).next('.hidden-content').hide();
			$(this).next('.hidden-content').removeClass('open');
		}
		else {
			$(this).next('.hidden-content').show();
			$(this).next('.hidden-content').addClass('open');
		}		
	
	});
	
	
	
	
	$('.tournament-click').click(function() {
		
		var url = $(this).next('.hidden-content').attr('data-url');
		$(this).next('.hidden-content').load(url + ' table.matches');
	
	
		$('table.matches', this).each(function(){
			
			$(this).append('<td>Hello World!</td>');
			
		});
	
	
	});





	$('.news-button a').click(function(){
		
		//alert("test" + this.getAttribute("data-id"));
		
	
		
		$('#news-feed').html('<div class="loader-container"><div class="loader"></div>loading</div>');
		
		
		
		var jsonUrl = $(this).attr('data-json');
		 	
		 //Retrieve JSON object and load data	
		 $.getJSON(jsonUrl, function(data) {
		 	
			
			
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
	
	
	
	$(function() {
		$("ul.dropdown-menu").on("click", "[data-stopPropagation]", function(e) {
			e.stopPropagation();
		});
	});
	
	
	
	
	
	$('.lightbox-click').click(function(){
		
		var lightboxId = $(this).attr('data-id');
		$('#' + lightboxId).css('display', 'block');
		
	
	});
	
	
	$('.lightbox').click(function(){
		
		$('.lightbox').css('display', 'none');
		
	
	});
	
	
	$(function() {
		$(".lightbox-content").on("click", function(e) {
			e.stopPropagation();
		});
	});
	
	
	
	
	

});