//    $(document).ready(function() {
            $("#name").keyup(function() {
                if ($(this).val().match(/[0-9]/g))
                    $("#txterr").html("Please Enter Only character");
                else if ($("#name").val() == "")
                    $("#txterr").html("Name Can't be Blank");
                else
                    $("#txterr").html("");
            });
            $("#email").keyup(function() {
                if ($(this).val().match(!
                        /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/g))
                    $("#txterremail").html("Invalid Email");
                else if ($("#email").val() == "")
                    $("#txterremail").html("Email Can't be Blank");
                else
                    $("#txterremail").html("");
            });
        // });
        $("#formsvalue").validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 20
                },
                phone: {
                    required: true,
                },
                email: {
                    required: true,
                },
                password: {
                    required: true,
                },
                confirmpassword: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: "Please enter  name",
                },
                phone: {
                    required: "Please enter phone",
                },
                email: {
                    required: "Please enter Email",
                },
                password: {
                    required: "Please enter password",
                },
                confirmpassword: {
                    required: "Please enter ConfirmPassword",
                },
            },
            errorElement: "span",
            errorPlacement: function(error, element) {
                error.insertAfter(element)
            }
        })
