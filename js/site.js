
// ---------------------------------
// EN MASSE
// ---------------------------------

(function( sitename, $, undefined ) {

	// ------------ private ------------

	function slideCycle() {
		// ....

	}

	function etc() {}

    // ------------ public ------------

	sitename.showTweets = function(user) {
		if (user == undefined) return;
		$.getJSON('http://twitter.com/statuses/user_timeline/'+user+'.json?callback=?', { count:5 }, 
		function(twitters) {
			var statusHTML = [];
			for (var i=0; i<twitters.length; i++){
				var username = twitters[i].user.screen_name;
				var status = twitters[i].text.replace(/((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;'">\:\s\<\>\)\]\!])/g, function(url) {
					return '<a href="'+url+'">'+url+'</a>';
				}).replace(/\B@([_a-z0-9]+)/ig, function(reply) {
					return reply.charAt(0)+'<a href="http://twitter.com/'+reply.substring(1)+'">'+reply.substring(1)+'</a>';
				});
				var actions = '<p class="actions"><a href="https://twitter.com/intent/tweet?in_reply_to='+twitters[i].id_str+'&amp;related=cdmn" class="reply" title="Reply">Reply</a><a href="https://twitter.com/intent/retweet?tweet_id='+twitters[i].id_str+'&amp;related=cdmn" class="retweet" title="Retweet">Retweet</a><a href="https://twitter.com/intent/favorite?tweet_id='+twitters[i].id_str+'&amp;related=cdmn" class="favourite" title="Favourite">Favourite</a></p>';

//				statusHTML.push('<li><p>'+status+'</p><p class="small">'+relative_time(twitters[i].created_at)+' via <a href="http://twitter.com/'+username+'/statuses/'+twitters[i].id_str+'">'+username+'</a></p>'+actions+'</li>');
				statusHTML.push('<li><p>'+status+'</p><p class="small">via <a href="http://twitter.com/'+username+'/statuses/'+twitters[i].id_str+'">'+username+'</a></p>'+actions+'</li>');
			}

			$('#twitter ul').html( statusHTML.join('') );
		});
	}

	sitename.init = function(options) {
		$('#slideshow').slideCycle();	// etc
		$('.carousel').carousel();		// etc

	};

    // ------------ start engines ------------

	$(sitename.init);

}( window.sitename = window.sitename || {}, jQuery ));



// ---------------------------------
// UNIVERSAL PLUGINS
// ---------------------------------

(function( $ ){

	$.fn.slideCycle = function(o) {
		o = $.extend({
			slide: '.slide',
			speed: 1000,
			timeout: 6000,
		},
		o || {});

		return this.each(function() {
			var c = $(this),
				slides = $(o.slide, c),
				playing = true,
				// zindex = 1,
				timer;

			slides.eq(0).fadeOut(0).addClass('active').fadeIn(1000, function(){ /* slides.fadeIn(0); */ }).css('z-index',1);
			if (slides.length <= 1) return;

			// c.click( next );

			timer = setTimeout(next, o.timeout);

			function next() {
				
				clearTimeout(timer);
				if (playing) timer = setTimeout(next, o.timeout);

				var old = slides.filter('.active').fadeOut(o.speed).removeClass('active');
				var active = old.next();
				if (active.length < 1) { active = slides.eq(0); }
				active.fadeIn(o.speed).addClass('active');

			}
		
		});

	}

})(jQuery);

