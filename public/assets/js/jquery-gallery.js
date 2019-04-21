(function($)
{
		$.fn.jquerygallery=function(options)
		{
				var defauts=
				{
					'coverImgOverlay' : true,
					'imgActive' : "imgActive",
					'thumbnail' : "coverImgOverlay",
					'thumbnailHeight' : 120,
					'overlay' : "overlay",
					'imgNext' : "<i class='fa fa-angle-right'></i>",
					'imgPrev' : "<i class='fa fa-angle-left'></i>",
					'imgClose' : "<i class='fa fa-times'></i>",
					'speed' : 300
				};
				var settings=$.extend(defauts, options);
				return this.each( function() {

					var imgActiveClass = "."+settings.imgActive,
									thumbnailClass = "."+settings.thumbnail,
									overlayClass = "."+settings.overlay;

					$("body").on("click","img[data-gallery]", function(){
					var link = $(this).attr("src"),
									dataGallery = $(this).data("gallery"),
									dataGalleryLength = $("img[data-gallery=\""+dataGallery+"\"]").length;

									$("<div class='"+settings.overlay+"'></div>").prependTo("body").fadeIn(100);
									$("<div class='"+settings.imgActive+"'></div>").prependTo(overlayClass).fadeIn(settings.speed);
									if(settings.coverImgOverlay){$("<div class='"+settings.thumbnail+"'></div>").appendTo(overlayClass).fadeIn(settings.speed);}
									$("<div class='prev' tabindex='3'>"+settings.imgPrev+"</div><div class='next' tabindex='1'>"+settings.imgNext+"</div><div class='close' tabindex='2'>"+settings.imgClose+"</div>").appendTo(overlayClass);

									//create every pictures on the related gallery and append them to main class or the thumbnails.
									$("img[data-gallery=\""+dataGallery+"\"]").each(function(i){
													var dataGallery = $(this).data("gallery");
													var imgLink = $(this).attr("src");
													$(imgActiveClass).append("<img src='"+imgLink+"' data-gallery='"+dataGallery+"' data-number='"+(i+1)+"'/>");
													if(settings.coverImgOverlay){$("<span data-thumbnail='yes'><img src='"+imgLink+"' data-gallery='"+dataGallery+"' data-number='"+(i+1)+"'/></span>").appendTo(thumbnailClass).hide().fadeIn(settings.speed);}
									});

									if(settings.coverImgOverlay) {
										$(imgActiveClass).find("img").css("border-bottom",settings.thumbnailHeight+"px solid transparent");
									}

									//Actions when sliding
									var slide = {
											next : function(){
													var widthImg = $(imgActiveClass).find("img:first-child").width(),
																	nextP = $(imgActiveClass).find("img:first-child").next();
													$(imgActiveClass).find("img:first-child").stop().animate({ "margin-left": "-10%", "opacity":0},settings.speed, function(){
																	$(imgActiveClass).find("img:first-child").hide();
																	$(this).css({"margin-left":0,"opacity":1}).appendTo(imgActiveClass);
																	nextP.fadeIn(settings.speed);
																	slide.isActive();
													});
											},
											prev : function(){
													var widthImg = $(imgActiveClass).find("img:first-child").width();
													$(imgActiveClass).find("img:first-child").stop().animate({"margin-left": "10%","opacity":0}, settings.speed, function(){
																	$(imgActiveClass).find("img:first-child").hide();
																	$(this).css({"margin-left":0,"opacity":1});
																	$(imgActiveClass).find("img:last-child").prependTo(imgActiveClass).fadeIn(settings.speed);
																	slide.isActive();
													});
											},
											//hide every pictures except the one that has been clicked.
											showImgActive : function(){
															$(imgActiveClass+" img").hide();
															$(imgActiveClass).find("img[src='"+link+"']").nextAll().prependTo(imgActiveClass);
															$(imgActiveClass).find("img[src='"+link+"']").prependTo(imgActiveClass).fadeIn(settings.speed);
											},
											//highlight the related thumbnail picture.
											isActive : function(){
															$(thumbnailClass+" img").css("opacity",0.2);
															$(thumbnailClass+" img").each(function(){
																	var activeSrc = $(imgActiveClass+" img:first-child").attr("src");
																	if ($(this).attr("src") == activeSrc){
																			var width = $(this).width()/2;
																			var offleft = $(this).offset().left;
																			var offsetLeft = $(thumbnailClass).offset().left;
																			var marginLeft = offsetLeft-offleft;
																			$(thumbnailClass).animate({"margin-left":marginLeft-width},settings.speed);
																			$(this).css("opacity",1);
																	}
															});
											}
									};

									//init slide
									slide.showImgActive();
									slide.isActive();

									if(dataGalleryLength<2){
											$(".prev,.next,"+thumbnailClass).remove();
//											$(imgActiveClass).css("padding-bottom",0);
									}
									if(dataGalleryLength>1){
									//Slide on click
									$(overlayClass).on("click",".prev,.next,"+imgActiveClass+", span[data-thumbnail='yes'],"+overlayClass+"",function(index){
											if($(this).hasClass("prev")){slide.prev();return false;}
											if($(this).hasClass("next") || $(this).hasClass(settings.imgActive)  ){slide.next();return false;}
											if($(this).attr("data-thumbnail")=="yes"){

													var sliderNumber = $(this).index()+1,
																	current = $(imgActiveClass+" img:first-child").data("number"),
																	next = $(this).find("img").data("number"),
																	widthImg = $(imgActiveClass+" img:first-child").width(),
																	nextP = $(this).find("img").attr("src"),
																	offleft = $(this).offset().left,
																	offsetLeft = $(thumbnailClass).offset().left,
																	marginLeft = offsetLeft-offleft,
																	width = $(this).width()/2;

													$(thumbnailClass+" img").css("opacity",0.2);
													$(this).find("img").css("opacity",1);

													if(sliderNumber!=current){
															$(thumbnailClass).animate({"margin-left":marginLeft-width},settings.speed);
															if(sliderNumber>current) {
																	$(imgActiveClass).find("img:first-child").stop().animate({"margin-left": "-10%", "opacity":0}, settings.speed, function(){
																					$(imgActiveClass+" img:first-child").hide();
																					$(imgActiveClass+" img:first-child").appendTo(imgActiveClass);
																					$(this).css({"margin-left":0, "opacity":1});
																					$(imgActiveClass+" img[src='"+nextP+"']").nextAll().prependTo(imgActiveClass);
																					$(imgActiveClass+" img[src='"+nextP+"']").prependTo(imgActiveClass).fadeIn(settings.speed);
																	});
															}
															if(sliderNumber<current) {
																	$(imgActiveClass).find("img:first-child").stop().animate({"margin-left": "10%", "opacity":0}, settings.speed, function(){
																					$(imgActiveClass+" img:first-child").hide();
																					$(imgActiveClass+" img:first-child").appendTo(imgActiveClass);
																					$(this).css({"margin-left":0, "opacity":1});
																					$(imgActiveClass+" img[src='"+nextP+"']").nextAll().prependTo(imgActiveClass);
																					$(imgActiveClass+" img[src='"+nextP+"']").prependTo(imgActiveClass).fadeIn(settings.speed);
																	});
															}
													}
													return false;
											}
									});
									}
									//Slide on keyboard
									$(document).keydown(function(event){
										if ( event.which == 39 || event.which ==38 ) {slide.next();}
										if ( event.which == 40 || event.which == 37 ) {slide.prev();}
									});
						return false;
					});

					$("body").on("click", ""+overlayClass+"" ,function(){
						$(this).fadeOut(function(){ $(this).remove(); });
					});
				});
		};
})(jQuery);
