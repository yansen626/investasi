function addCommas(nStr) {
    nStr += '';
    x = nStr.split(',');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + '.' + '$2');
    }
    return "Rp " + x1 + x2;
}

$('input[type=radio][name=amount]').change(function() {
    var amount = parseInt(this.value);
    var totalAmount = amount + 4000;
    var totalAmountStr = addCommas(totalAmount);
    $("#wallet-deposit-amount").html(addCommas(amount));
    $("#wallet-deposit-cost").html(totalAmountStr);
});

// function onSelectTopUp(e){
//     if(e.value == "0"){
//         $("#custom_amount_section").show();
//     }
//     else{
//         $("#custom_amount_section").hide();
//     }
// }




$(function(){
    $('#subscribe-form').on('submit',function(e){

        e.preventDefault();
        $("#subscribe-button").attr("disabled", true);
        $("#subscribe-spinner").show();
        var name = '';
        if($('#name').length > 0){
            name = $('#name').val();
        }
        var email = '';
        if($('#email').length > 0){
            email = $('#email').val();
        }
        var phone = '';
        if($('#phone').length > 0){
            phone = $('#phone').val();
        }

        $.ajax({
            url     : urlLink,
            method  : 'POST',
            data    : {
                // _token: CSRF_TOKEN,
                name  : name,
                email : email,
                phone : phone
            },
            headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            success : function(response){
                if(response.success === true){
                    $('#modal-success').modal();
                    $("#subscribe-button").attr("disabled", false);
                    $("#subscribe-spinner").hide();
                }
                else{
                    alert("There's something wrong!");
                }
            },
            error:function(){
                alert('error');
            }
        });
    });

    $('#contact-form').on('submit',function(e){

        e.preventDefault();
        var namecontact = '';
        if($('#namecontact').length > 0){
            namecontact = $('#namecontact').val();
        }
        var emailContact = '';
        if($('#emailContact').length > 0){
            emailContact = $('#emailContact').val();
        }
        var phone = '';
        if($('#phone').length > 0){
            phone = $('#phone').val();
        }
        var description = '';
        if($('#description').length > 0){
            description = $('#description').val();
        }
        $.ajax({
            url     : urlLinkContactUs,
            method  : 'POST',
            data    : {
                // _token: CSRF_TOKEN,
                name  : namecontact,
                email  : emailContact,
                phone  : phone,
                description : description
            },
            headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            success : function(response){
                if(response.success === true){
                    $('#contactUsPopup').modal('hide');
                    $('#modal-success-contact').modal();
                }
                else{
                    alert(response.error);
                    // alert("There's something wrong!");
                }
            },
            error:function(){
                alert('error');
            }
        });
    });
});