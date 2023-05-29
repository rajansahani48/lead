// $("#name").keyup(function () {
//     if ($(this).val().match(/[0-9]/g))
//         $("#txterr").html("Please Enter Only character");
//     else if ($("#name").val() == "")
//         $("#txterr").html("Name Can't be Blank");
//     else
//         $("#txterr").html("");
// });
// $("#email").keyup(function () {
//     if ($(this).val().match(!
//         /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/g))
//         $("#txterremail").html("Invalid Email");
//     else if ($("#email").val() == "")
//         $("#txterremail").html("Email Can't be Blank");
//     else
//         $("#txterremail").html("");
// });

// $("#telecallerFormData").validate({
//     rules: {
//         name: {
//             required: true,
//             maxlength: 50,
//             lettersonly: true

//         },
//         phone: {
//             required: true,
//         },
//         email: {
//             required: true,
//         },
//         password: {
//             required: true,
//         },
//         confirmpassword: {
//             required: true,
//         },
//     },
//     messages: {
//         name: {
//             required: "Please enter  name",
//         },
//         phone: {
//             required: "Please enter phone",
//         },
//         email: {
//             required: "Please enter Email",
//         },
//         password: {
//             required: "Please enter password",
//         },
//         confirmpassword: {
//             required: "Please enter ConfirmPassword",
//         },
//     },
//     errorElement: "span",
//     errorPlacement: function (error, element) {
//         error.insertAfter(element)
//     }
// })


$("#editTelecallerForm").validate({
    rules: {
        name: {
            required: true,
            maxlength: 50,
            lettersonly: true

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
    errorPlacement: function (error, element) {
        error.insertAfter(element)
    }
});

jQuery.validator.addMethod("lettersonly", function (value, element) {
    return this.optional(element) || /^[a-zA-Z\s]+$/i.test(value);
}, "");

//add telecaller
$(".addTelecaller").click(function(event) {

    event.preventDefault();
    $.ajax({
        url: 'telecaller',
        data: $("#telecallerFormData").serializeArray(),
        method: "POST",
        dataType: 'json',
        headers: {
            'X-CSRF-Token': "{{ csrf_token() }}"
        },
        success: function(data) {
            if (data.telecallerCreated) {
                Swal.fire({
                    position: 'center-center',
                    icon: 'success',
                    title: 'Telecaller Created Successfully!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    $('#createTelecaller').modal('hide');
                }).then(function(){
                    location.reload();
                });
            }
            if(data.userAlreadyExists)
            {
                Swal.fire({
                    position: 'center-center',
                    icon: 'error',
                    title: 'Email Already Exists!',
                    showConfirmButton: false,
                    timer: 1000
                });
            }
        }
    });
});

//edit telecaller
$(".editTelecaller").click(function(event) {
    event.preventDefault();
    telecaller_id = $(this).data('telecaller_id');
    $.ajax({
        url:"telecaller/" + telecaller_id+ "/edit",
        data: telecaller_id,
        method: "GET",
        dataType: 'json',
        headers: {
            'X-CSRF-Token': "{{ csrf_token() }}"
        },
        success: function(data) {
            $("#editTelecallerModal").modal('show');
            console.log(data.obj);
            $("#editid").val(data.obj.id);
            $("#editname").val(data.obj.name);
            $("#editemail").val(data.obj.email);
            $("#editphone").val(data.obj.phone);
            $("#editcountrycode").val(data.obj.country_code);
            $("#editaddress").val(data.obj.address);
        }
    });
});

$(".updateTelecaller").click(function(event) {
    event.preventDefault();
    telecaller_id = $(this).data('telecaller_id');
    $.ajax({
        url:"telecaller/" + telecaller_id,
        data: $("#editTelecallerForm").serializeArray(),
        method:"PUT",
        dataType: 'json',
        headers: {
            'X-CSRF-Token':$('#editcsrf').val()
        },
        success: function(data) {
            if(data.telecallerUpdated)
            {
                Swal.fire({
                    position: 'center-center',
                    icon: 'success',
                    title: 'Telecaller Updated Successfully!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    $('#editTelecallerModal').modal('hide');
                }).then(function(){
                    location.reload();
                });
            }
            if(data.userAlreadyExists)
            {
                Swal.fire({
                    position: 'center-center',
                    icon: 'error',
                    title: 'Email Already Exists!',
                    showConfirmButton: false,
                    timer: 1000
                });
            }
        }
    });
});


$(".deleteBtn").click(function (e) {
    e.preventDefault();
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to get this data Again!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {

            telecaller_id = $(this).data('telecaller_id');
            $.ajax({
                url: "telecaller/"+telecaller_id,
                type: "DELETE",
                dataType: 'json',
                contentType: false,
                cache: false,
                headers: {
                    'X-CSRF-Token': $('#deletecsrf').val()
                },
                processData: false,
                success: function (data) {
                    if (data.deleteTelecallerError) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: "You Can't Delete this Telecaller Due To Incomplete Task!!",
                        })
                    } else {
                        Swal.fire(
                            'Deleted!',
                            'Telecaller has been deleted.',
                            'success'
                        ).then(function () {
                            location.reload();
                        });
                    }
                }
            })
        }
    })
});
