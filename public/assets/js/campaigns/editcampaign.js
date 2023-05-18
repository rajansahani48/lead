$("#campaign_name").keyup(function () {
    if ($(this).val().match(/[0-9]/g))
        $("#txterr").html("Please Enter Only character");
    else if ($("#name").val() == "")
        $("#txterr").html(" Name Can't be Blank");
    else
        $("#txterr").html("");
});
$("#editCampaignForm").validate({
    rules: {
        campaign_name: {
            required: true,
            maxlength: 20
        },
        cost_per_lead: {
            required: true,
        },
        conversion_cost: {
            required: true,
        },
        file: {
            required: true,
        },
    },
    messages: {
        campaign_name: {
            required: "Please enter Campaign name",
        },
        cost_per_lead: {
            required: "Please enter Cost per lead",
        },
        conversion_cost: {
            required: "Please enter Conversion cost",
        },
        file: {
            required: "Please select csv",
        },
    },
    errorElement: "span",
    errorPlacement: function (error, element) {
        error.insertAfter(element)
    }
})
