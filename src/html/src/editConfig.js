$('.row-data').click(function(e) {
    e.preventDefault(); 

    //make div editable
    $(this).closest('div').attr('contenteditable', 'true');
    
    //add bg css
    $(this).addClass('bg-warning').css('padding','5px');

    $(this).focus();
});


$(document).on("focusout",".row-data.bg-warning",function(e){
    e.preventDefault();
    $(this)
        .removeClass('bg-warning') //add bg css
        .css('padding','');

    var arr = {};

    $(".row-data").each(function () {
        var name = $(this).attr('name');
        var value = $(this).text();
        if (name === null) return;

        arr[name] = value;

    });

    console.log(arr);

    $.ajax({
        type: 'PUT',
        url: '/src/rest/ConfigRest.php',
        data: arr
    })
        .done(function(data) {
            console.log('Complete response = ' + data);
        });

    $('#config').load(window.location.href + " #config");
});