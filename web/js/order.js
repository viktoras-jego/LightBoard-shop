/**
 * Created by viktoras on 17.3.28.
 */


(function() {
    var tl = new TimelineMax({})
    var twimg = new TimelineMax({})
    var tl2 = new TimelineMax({})
    var logo = new TimelineMax({})
    var light = document.getElementById("light");
    var board = document.getElementById("board");
    var buy = document.getElementById("btn-buy");
    var box = document.getElementById("buy-box");
    var image = document.getElementById("order-image");
    var black1 = document.getElementById("black-box1");
    var black2 = document.getElementById("black-box2");

    $(".order-image").hover(over, out);

    function over(){
        TweenMax.to(this, 0.2,{
            ease: Power1. easeOut,
            borderColor:"#000000"
        })
    }

    function out(){
        TweenMax.to(this, 0.2, {ease: Power1. easeOut,
            borderColor:"#FFFFFF"
        })
    }



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