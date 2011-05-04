var start_frame = 0;

function initSlideshow(id, delay) {
	var slideshow_delay = delay;
	var slideshow_id = id;
	var lis = $(slideshow_id).getElementsByTagName('li');
	
	var max = 0;
	for(var i=0; i < lis.length; i++){
		if (lis[i].firstChild.offsetHeight > max) {
			max = lis[i].firstChild.offsetHeight;
		}
		if(i!=0){
			lis[i].style.display = 'none';
		}
	}
	//$(slideshow_id).parentNode.style.height = max+"px";
        changeWindow(slideshow_id, "auto", "auto", false, false);
	
	var end_frame = lis.length -1;
	
	start_slideshow(start_frame, end_frame, slideshow_delay, slideshow_id, lis);
	
	
}



function start_slideshow(start_frame, end_frame, slideshow_delay, slideshow_id, lis) {
	setTimeout(fadeInOut(start_frame,start_frame,end_frame, slideshow_delay, slideshow_id, lis), slideshow_delay);
}


function fadeInOut(frame, start_frame, end_frame, slideshow_delay, slideshow_id, lis) {
	return (function() {
		lis = $(slideshow_id).getElementsByTagName('li');
		Effect.Fade(lis[frame]);
                lisFade = lis[frame];
		if (frame == end_frame) { frame = start_frame; } else { frame++; }
		lisAppear = lis[frame];
		lisAppear.style.position = 'relative';
		lisFade.style.position = 'absolute';
		changeWindow(slideshow_id, "auto", "auto", false, false);
                Effect.Appear(lisAppear);
                setTimeout(fadeInOut(frame, start_frame, end_frame, slideshow_delay, slideshow_id), slideshow_delay + 1100);
	})
	
}

//Event.observe(window, 'load', function() {initSlideshow('slide-images', 2000);}, false);