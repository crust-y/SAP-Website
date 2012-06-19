  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-3303905-4']);
  _gaq.push(['_trackPageview']);

  (function () {
      var ga = document.createElement('script');
      ga.type = 'text/javascript';
      ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0];
      s.parentNode.insertBefore(ga, s);
  })();
  google.load("webfont", "1");
  google.setOnLoadCallback(function () {
      WebFont.load({
          google: {
              families: ['Ubuntu+Condensed', 'Varela+Round', 'PT+Sans+Narrow']
          }
      });
  });
  $(window).load(function () {
      setTimeout(function () {
          $('#slider2').nivoSlider({
              pauseTime: 4500,
              pauseOnHover: true
          });
      }, 700);
      $.getJSON('http://' + document.domain + '/index.php?request=facebook', function (json) {
          $('#facebook_time').html(unescape(json.time));
          $('#facebook_post').html(unescape(json.post));
          $('#facebook_title').html(unescape(json.title));
      });
      new Image().src = 'http://' + document.domain + '/images/social_fb_over.jpg';
      new Image().src = 'http://' + document.domain + '/images/social_twitter_over.jpg';
      $(function () {
          $('a[href^="mailto:"]').each(function () {
              this.href = this.href.replace('(at)', '@').replace(/\(dot\)/g, '.');
              this.innerHTML = this.href.replace('mailto:', '');
          });
      });
  });
  $(document).ready(function () {
      if (window.location.hash != '') {
          $('html,body').animate({
              scrollTop: $('#_' + window.location.hash.replace('#', '')).offset().top
          }, 1500);
      }
  });