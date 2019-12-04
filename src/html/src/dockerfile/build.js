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
    $.ajax({
        type: 'POST',
        url: '/src/restclient/CommandExecution.php',
        data: {cmd : $('#build-command').text()},
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
            console.log('Complete response = ' + data);
        })
        .fail(function(data)
        {
            console.log('Error: ', data);
        });
    console.log('Request Sent');
});