$uploadCrop = $('#upload-demo').croppie({

    enableExif: true,

    viewport: {

        width: 200,

        height: 200,

        type: 'circle'

    },

    boundary: {

        width: 300,

        height: 300

    }

});


$('#upload').on('change', function () {

    var reader = new FileReader();

    reader.onload = function (e) {

        $uploadCrop.croppie('bind', {

            url: e.target.result

        }).then(function(){

            console.log('jQuery bind complete');

        });



    }

    reader.readAsDataURL(this.files[0]);

});


$('.upload-result').on('click', function (ev) {

    $uploadCrop.croppie('result', {

        type: 'canvas',

        size: 'viewport'

    }).then(function (resp) {


        $.ajax({

            url: "/ajaxpro.php",

            type: "POST",

            data: {"image":resp},

            success: function (data) {

                html = '<img src="' + resp + '" />';

                $("#upload-demo-i").html(html);

            }

        });

    });

});