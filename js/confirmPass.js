$( document ).ready(function() {
    console.log( "ready!" );
jQuery.validator.setDefaults({
  debug: false,
  success: "valid"
});

$('#form1').validate({
    rules:{
    Email:
            {
            required:true,
            email:true
            },
    newpassword:
            {
            required:true,
            minlength:3,
            maxlength:10
            },
    newpassword1:{
            required:true,
            equalTo:"#password"
            }
          },

          highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if(element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }

})
});