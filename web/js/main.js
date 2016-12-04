CSSPlugin.defaultSmoothOrigin = true;
var tl = new TimelineMax({
   delay:0.5,
});
var at = new TimelineMax({
   delay:0.5,
});

at.to(".logo1",0,{

   rotation: 135.3,
   right:1,
   y:71
});

tl.to(".logo",0,{

   rotation: -45.3,
   left:1
});

at.from(".logo1",0.7,{
   opacity:0,
   right:800,
   rotation: 0,
   delay:1.5
});

tl.from( ".login", 1, {
   ease:
       CustomEase.create("custom", "M0,0,C0.62,0.12,0.642,0.18,0.748,0.338,0.852,0.493,0.842,0.578,1,1"),
   y: -500
});



TweenMax.staggerFrom(".box",0.5,{
   opacity:0,
   y:200,
   delay:0.5,
   rotation:720,
   scale:2,
},
0.2
)
