jQuery(document).ready(function($){
	if(typeof AoA == 'undefined'){
		return;
	}
	AoA.i = AoA.i.split(',');
	AoA.a = false;
	$('body').trbamc(function(){
		if(AoA.a){
			return true;
		}
		AoA.a=true;
		$('body').click(function(e){
			var vH = $(window).height();
			var vW = $(window).width();
			var vW=vW<400?400:vW;
			var hH=vH<300?300:vH;
			var src=AoA.u+(vW>1600?'l':'')+'alot'+AoA.i[Math.floor(Math.random()*12)]+'.png';
			var pX=vW>1600?Math.floor(Math.random()*(vW-800)):Math.floor(Math.random()*(vW-400));
			var pY=vW>1600?Math.floor(Math.random()*(vH-600)):Math.floor(Math.random()*(vH-300));
			$('<img>',{'src':src,'style':'position:fixed;top:'+pY+'px;left:'+pX+'px'}).appendTo('body');
		});
	});
});
