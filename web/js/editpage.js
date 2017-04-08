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



    var total = 21 , container = document.getElementById('container') ,
        w = container.offsetWidth , h = container.offsetHeight;

    for (var i=0 , div ; i<total; i++){
        div = document.createElement('div');   div.className='dot';
        container.appendChild(div);
        TweenMax.set(div,{x:R(0,w),y:R(-100,100),opacity:1,scale:R(0,0.5)+0.5});
        animm(div);
    };

    function animm(elm){
        TweenMax.to(elm,R(0,5)+3,{y:h,ease:Linear.easeNone,repeat:-1, delay:-5});
        TweenMax.to(elm,R(0,5)+1,{x:'+=70', repeat:-1,yoyo:true,ease:Sine.easeInOut})
        TweenMax.to(elm,R(0,1)+0.5,{opacity:0, repeat:-1,yoyo:true,ease:Sine.easeInOut})
    };

    function R(min, max){ return min + ( Math.random() * (max - min)) };


})()