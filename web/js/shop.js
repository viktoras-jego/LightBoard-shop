

CSSPlugin.defaultSmoothOrigin = true;




(function() {
    var abc1 = 1;
    var abc = new TimelineMax({})
    var logo = new TimelineMax({})
    var sid = new TimelineMax({paused:true})
    var playBtn = document.getElementById("login1");
    var login = document.getElementById("log");
    var sidebar = document.getElementById("sidebar");
    var light = document.getElementById("light");
    var board = document.getElementById("board");
    var shop = document.getElementById("shop-text");
    var fast = document.getElementById("fast-text");
    var easy = document.getElementById("easy-text");
    var convenient = document.getElementById("convenient-text");

    var tl = new TimelineMax({});
    tl.to(fast, 0, {
        y: 100
    });
    tl.to(easy, 0, {
        y: 100
    });
    tl.to(convenient, 0, {
        y: 100
    });
    tl.to(fast, 0.6, {
        y: 100
    });
    tl.to(fast, 0.6, {
        y: 0
    });
    tl.to(easy, 0.6, {
        y: 0
    });
    tl.to(convenient, 0.6, {
        y: 0
    });



    logo.to(board, 0, {
        x: -63,
    });


    $(".image_object").hover(over, out);

    function over(){
        TweenMax.to(this, 0.1,{ease: Power1. easeOut, scaleX:1.04, scaleY:1.04})
    }

    function out(){
        TweenMax.to(this, 0.1, {ease: Power1. easeOut, scaleX:1, scaleY:1})
    }


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


    if(playBtn) {

        abc.to(login, 0, {
            x: 15,
        });
        abc.to(sidebar, 0, {
            y: -78,

        });
        abc.to(login, 0, {
            y: -151,
        });
        sid.from(login, 1.3, {
            x: -231.8,
        });
        if (sidebar) {
            sid.from(sidebar, 1.32, {
                x: -246.8,
                delay: -1.3,
            });
        }

        playBtn.onclick = function () {
            if(abc1 ==1){

                sid.play();
                abc1++;
                console.log(abc1);
            }

            else if(abc1 ==2){
                sid.reverse();
                abc1--;
                console.log(abc1);
            }

        }

    }

})()