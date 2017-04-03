/**
 * Created by viktoras on 17.4.3.
 */
CSSPlugin.defaultSmoothOrigin = true;


(function() {
    var abc = new TimelineMax({});
    var abc2 = new TimelineMax({});
    var tl = new TimelineMax({});
    //var sid = new TimelineMax({paused:true});
    var title = document.getElementById("title");
    var line = document.getElementById("line");
    var image = document.getElementById("image");
    var image2 = document.getElementById("image2");
    var linecolumn = document.getElementsByClassName("line-column");

   tl.to(linecolumn, 4,{
            x:400,y:-400,
       repeat:-1,
       ease:Linear.easeNone
        })
   tl.play();

    abc.to(line, 0,{
        x:-922
    })
    abc.to(title, 0,{
        ease: Power1. easeOut,
        scaleX:0.70,
        scaleY:0.70
    })
    abc.to(image, 0,{
        ease: Power1. easeOut,
        scaleX:0.76,
        scaleY:0.76,
        y:150,
        x:30
    })
    abc.to(image2, 0,{
        ease: Power1. easeOut,
        scaleX:0.76,
        scaleY:0.76,
        y:-150,
        x:-30
    })
    abc.to(title, 0.9,{
        ease: Power1. easeOut,
        scaleX:1.0,
        scaleY:1.0
    })
    abc.to(line, 1.0,{
        x:0
    })
    abc2.to(image2, 1.9,{

    })
    abc.to(image, 0.6,{
        ease: Power3. easeOut,
        y:0
    })
    abc2.to(image2, 0.6,{
        ease: Power3. easeOut,
        y:0
    })






    var tl = new TimelineMax({})
    var tl2 = new TimelineMax({})
    var logo = new TimelineMax({})
    var light = document.getElementById("light");
    var board = document.getElementById("board");
    var buy = document.getElementById("btn-buy");
    var box = document.getElementById("buy-box");

    logo.to(board, 0, {
        x: -63,
    });

    $(".nav-logo").hover(over2, out2);

    function over2(){
        TweenMax.to(board, 1.3,{
            x:-1,
            ease: Power4. easeOut,
        })
    }

    function out2(){
        TweenMax.to(board, 1.3, {
            x:-63,
            ease: Power4. easeOut,
        })
    }

    $("#btn-buy").click(function() {
        tl.to(box, 0, {
            display: 'block',
        });
        $('html, body').animate({
            scrollTop: $("#buy-box").offset().top
        }, 2000);

    });

})()


