$(function () {
    $('#findAddress').on('click',function () {
        var $key='GEpcw5A70k-fLjWoipm_Hg12113';
        var $pCode=$('#pcode').val().trim();
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

