

CSSPlugin.defaultSmoothOrigin = true;




(function() {
    var abc1 = 1;

    var abc = new TimelineMax({})
    var sid = new TimelineMax({paused:true})
    var playBtn = document.getElementById("login1");
    var login = document.getElementById("log");
    var sidebar = document.getElementById("sidebar");










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


    var tl = new TimelineMax({

    });
    var at = new TimelineMax({

    });




    at.to(".logo1",0,{

        rotation: 135.3,
        right:1,
        x:38,
        y:20
    });



    tl.to(".logo",0,{

        x:-46.8,
        y:18,
        rotation: -44.8,
        left:1
    });

    at.from(".logo1",0.7,{
        ease: Power1. easeIn,
        opacity:0,
        right:800,
        rotation: 0,
        delay:0.5
    });

    tl.from(".logo",0.7,{
        ease: Power1. easeIn,
        opacity:0,
        left:800,
        rotation: 0,
        delay:0.5
    });

    at.to(".logo1",1.5,{
        ease: Power3. easeOut,
        rotation:720,


    });



    tl.to(".logo",1.5,{
        ease: Power3. easeOut,
        rotation: 540,

    });
    tl.to(".logo",1,{
        ease: Power3. easeOut,
        left:19,
        top:18,
    });




    at.to(".logo1",2,{
        ease: Power3. easeOut,
        rotation:720,
    });
    at.to(".logo1",1,{
        ease: Power3. easeOut,
        right:19,
        bottom:18,
        delay:-2
    });



})()