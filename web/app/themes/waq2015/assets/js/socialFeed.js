//
// WAQ2015 SOCIAL FEED
// socialFeed.js
//

(function($){
  $.extend($.fn, {
    
    window.getSocialFeed = function(args){

      var posts = {
        instagram: {
          url: 'https://api.instagram.com/v1/tags/waq2015/media/recent?client_id=***REMOVED***&count=5',
          raw: undefined,
          posts: []
        },
        twitter: {
          url: 'https://api.twitter.com/1.1/search/tweets.json?q=waq&result_type=recent&count=5',
          raw: undefined,
          posts: []
        }
      }

    }

  });
})(jQuery);