<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    	<title>PT. Putra Mutiara Jaya (Printmate) </title>
    <link href="stylesheet.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/reset.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/grid.css" type="text/css" media="screen" />   
    <script src="js/jquery-1.6.2.min.js" type="text/javascript"></script> 
    <script src="js/jquery.easing.1.3.js" type="text/javascript"></script>
    <script src="js/jcarousellite_1.0.1.js" type="text/javascript"></script>
    <script src="js/jquery.galleriffic.js" type="text/javascript"></script>
    <script src="js/jquery.opacityrollover.js" type="text/javascript"></script> 
    <script type="text/javascript">
		$(document).ready(function() { 
			$(".jCarouselLite").jCarouselLite({
				  btnNext: ".next",
				  btnPrev: ".prev",		  
				  speed: 400,		  
				  vertical: false,
				  circular: true,
				  easing:'easeOutQuart',
				  visible: 4,
				  start: 0,
				  scroll: 1
			 });
		});
	</script>    
  
    
</head>
<body>
 	<div class="main_container" >
        <a href="index.php"><img src="images/logoprintmate.png" align="left" /></a>
            <div id="headr_img">
                <span id="main_nav"> 
                	   	<a href="index.php">Home</a> |  
						<a href="#">Gallery</a> |  
                        <a href="reserve.php">Booking Service</a> |  
                        <a href="contact.php">Contact Us</a>
	            </span>
            </div>
 <!-- content -->
    <section id="content">
        <div class="bg-top">
        	<div class="bg-top-2">
                <div class="bg">
                    <div class="bg-top-shadow"> 
                        <div class="main">
                                <h4 id="home_header">Accomodations & Facilities</h4><br />
        <p style="font-size:16px;">We are now Officially licensed to endorse many world brand such as canon, hp, mimaki, gmg color dilli, winjet, chemica, etc.</p><br/>
        <p style="font-size:16px;">We Provided Complete Solutions like as Unit Printer, Original Ink, 3rd Party Ink, 
        Spare part, Indoor 'n Outdoor Print Media, Finishing Material, Sign Graphic Display System.</p><br/>
                            <div class="gallery p3">
                            	<div class="wrapper indent-bot">
                                    <div id="gallery" class="content"> 
                                       <div class="wrapper">
                                           <div class="slideshow-container">
                                                <div id="slideshow" class="slideshow"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="thumbs" class="navigation">
                                        <ul class="thumbs noscript">
                                            <li>
                                                <a class="thumb" href="galeri/pic1.jpg" title=""> <img src="galerideui/thumb-1.jpg" alt="" /><span></span> </a>
                                            </li> 
                                            <li>
                                                <a class="thumb" href="galeri/pic2.jpg" title=""> <img src="galerideui/thumb-2.jpg" alt="" /> <span></span></a>
                                            </li> 
                                            <li>
                                                <a class="thumb" href="galeri/pic3.jpg" title=""> <img src="galerideui/thumb-3.jpg" alt="" /> <span></span></a>
                                            </li> 
                                            <li>
                                                <a class="thumb" href="galeri/pic4.jpg" title=""> <img src="galerideui/thumb-4.jpg" alt="" /> <span></span></a>
                                            </li> 
                                            <li>
                                                <a class="thumb" href="galeri/pic5.jpg" title=""> <img src="galerideui/thumb-5.jpg" alt="" /> <span></span></a>
                                            </li> 
                                            <li>
                                                <a class="thumb" href="galeri/pic6.jpg" title=""> <img src="galerideui/thumb-6.jpg" alt="" /> <span></span></a>
                                            </li>           
                                        </ul>
                                    </div>
                                </div>
                                
                             </div>
                       </div>
                    </div>
                </div>
            </div>	
       </div>
    </section>
     
    <script type="text/javascript">
			$(window).load(function() {
			// We only want these styles applied when javascript is enabled
			$('div.navigation').css({'width' : '320px', 'float' : 'right'});
			$('div.content').css('display', 'block');
	
			// Initially set opacity on thumbs and add
			// additional styling for hover effect on thumbs
			var onMouseOutOpacity = 0.5;
			$('#thumbs ul.thumbs li span').opacityrollover({
				mouseOutOpacity:   onMouseOutOpacity,
				mouseOverOpacity:  0.0,
				fadeSpeed:         'fast',
				exemptionSelector: '.selected'
			});
			
			// Initialize Advanced Galleriffic Gallery
			var gallery = $('#thumbs').galleriffic({
				delay:                     7000,
				numThumbs:                 12,
				preloadAhead:              6,
				enableTopPager:            false,
				enableBottomPager:         false,
				imageContainerSel:         '#slideshow',
				controlsContainerSel:      '',
				captionContainerSel:       '',
				loadingContainerSel:       '',
				renderSSControls:          true,
				renderNavControls:         true,
				playLinkText:              'Play Slideshow',
				pauseLinkText:             'Pause Slideshow',
				prevLinkText:              'Prev',
				nextLinkText:              'Next',
				nextPageLinkText:          'Next',
				prevPageLinkText:          'Prev',
				enableHistory:             true,
				autoStart:                 7000,
				syncTransitions:           true,
				defaultTransitionDuration: 900,
				onSlideChange:             function(prevIndex, nextIndex) {
					// 'this' refers to the gallery, which is an extension of $('#thumbs')
					this.find('ul.thumbs li span')
						.css({opacity:0.5})
				},
				onPageTransitionOut:       function(callback) {
					this.find('ul.thumbs li span').css({display:'block'});
				},
				onPageTransitionIn:        function() {
					this.find('ul.thumbs li span').css({display:'none'});
				}
			});
		});
	</script> 
    <div id="footer_container">
         	Copyright © 2017 Toni Wahyudi - TA_MI @ Piksi Ganesha
    </div>
    </div>
    </body>
</html>