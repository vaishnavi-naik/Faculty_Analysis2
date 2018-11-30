$( document ).ready(function() {
    console.log( "ready!" );
jQuery.validator.setDefaults({
  debug: false,
  success: "valid"
});

$('#passForm').validate({
    rules:{
    oldpassword:
            {
            required:true,
            minlength:3,
            maxlength:20
            },
    newpassword:
            {
            required:true,
            minlength:3,
            maxlength:20
            },
    newpassword1:{
            required:true,
            equalTo:"#newpassword"
            }
          },

          highlight: function(element) {
            $(element).addClass('is-invalid');

        
        },
        unhighlight: function(element) {
            $(element).addClass('is-invalid');
        },
        errorElement: 'span',
        errorClass: 'invalid-feedback',
        errorPlacement: function(error, element) {
            if(element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }

})
});