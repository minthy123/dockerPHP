$('#button-build-image').click(function(e) {
    e.preventDefault();
    
    if($(this).hasClass('processing')) 
        return; 
    
    $(this).addClass('processing') ;
    
    Terminal.applyAddon(fit);
    const term = new Terminal({ windowsMode: true });
    const container = document.getElementById('build-docker-log');
    term.open(container);
    term.fit();

    var lastResponseLength = false;
    var host_id = $( "select#chosen-host option:checked" ).val();

    $.ajax({
        type: 'POST',
        url: '/src/restclient/CommandExecution.php',
        data: {cmd : $('#build-command').text(), "host-id": host_id},
        xhrFields:  {
            onprogress: function(e) {
                var progressResponse;
                var response = e.currentTarget.response;

                if (lastResponseLength === false) {
                    progressResponse = response;
                    lastResponseLength = response.length;
                } else {
                    progressResponse = response.substring(lastResponseLength);
                    lastResponseLength = response.length;
                }

                term.write(progressResponse);
            }
        }
    })
        .done(function(data) {
            if (data.includes("returned a non-zero code: 127")) {
                swal({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!'
                });
            } else {
                swal({
                    title: 'Done',
                    text: 'Your image was built success. Do you want to check out?',
                    type: 'success',
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    reverseButtons: true,
                    buttonsStyling: false
                }).then((result) => {
                    if (result.value) {
                        var lastSplash = window.location.href.lastIndexOf('/');
                        window.location.href = window.location.href.substr(0, lastSplash + 1) + "image.php?host-id=" + host_id + "&image-id=" + $("#image-name").text();
                    }
                });
            }

            //console.log('Complete response = ' + data);
        })
        .fail(function(data)
        {
            console.log('Error: ', data);
        });
    console.log('Request Sent');
});