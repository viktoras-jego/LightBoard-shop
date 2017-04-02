/**
 * Created by viktoras on 17.4.2.
 */
(function() {
    var tl = new TimelineMax({})
    var tl2 = new TimelineMax({})
    var logo = new TimelineMax({})
    var light = document.getElementById("light");
    var board = document.getElementById("board");
    var buy = document.getElementById("btn-buy");
    var btnchng = document.getElementById("change");
    var croppie = document.getElementById("croppie-block");
    var image = document.getElementById("change-img");

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


    $("#change").click(function() {
        tl.to(btnchng, 0, {
            display: 'none',
        });
        tl.to(image, 0, {
            display: 'none',
        });
        tl.to(croppie, 0, {
            display: 'block',
        });

    });




})()