$('.row-data').click(function(e) {
    e.preventDefault(); 

    //make div editable
    $(this).closest('div').attr('contenteditable', 'true');
    
    //add bg css
    $(this).addClass('bg-warning').css('padding','5px');

    $(this).focus();
})


$(document).on("focusout",".row-data.bg-warning",function(e){
    e.preventDefault();

    var row_id = $(this).closest('tr').attr('row_id'); 
    
    var row_div = $(this)				
        .removeClass('bg-warning') //add bg css
        .css('padding','')

    var col_val = row_div.html(); 
    console.log(col_val);

    //var arr = {};
    //arr[col_name] = col_val;

    //use the "arr"	object for your ajax call
    //$.extend(arr, {row_id:row_id});

    //out put to show
    //$('.post_msg').html( '<pre class="bg-success">'+JSON.stringify(arr, null, 2) +'</pre>');
})