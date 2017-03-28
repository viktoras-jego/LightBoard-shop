
(function () {
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {



                //$('#upload-demo').attr('src', e.target.result);
                $('#upload-demo').croppie('bind', {
                    url: e.target.result

                })
                $uploadCrop.croppie('result', {type:'base64'}).then(function(res) {
                    var res1 = res.replace(/^data:image\/(png|jpg);base64,/, "");

                    });

            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInp").change(function(){

        readURL(this);
    });
})();

