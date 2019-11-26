$('#button-build-image').click(function() {
    // $.post('/src/restclient/CommandExecution.php', {cmd : $('#build-command').text()})
    // 	.done(function(data) {
    // 		$('#build-docker-log').append(data);
    // 	});
    // console.log('Request Sent');
    //Terminal.applyAddon(winptyCompat);

    Terminal.applyAddon(fit);

    // The terminal
    const term = new Terminal({ windowsMode: true });

    // This kinda makes sense
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