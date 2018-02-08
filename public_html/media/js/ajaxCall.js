$(function () {
    $('#findAddress').on('click',function () {
        var $key='eK7S7hMgwECk4puypAK_6Q12122';
        var $pCode=$('#pcode').val();
        console.log($pCode);

        $.ajax({
            type: 'GET',
            url: 'https://api.getAddress.io/find/' + $pCode + '?api-key=' + $key,
            dataType: 'json',
            data: {get_param: 'addresses'},
            success:function(data){
                $.each(data.addresses,function(i,value){
                    $("#address").append($('<option></option>').val(value).html(value))
                })
            }
        });
    });
});

