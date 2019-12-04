function checkLogContainer(containerId) {
    Terminal.applyAddon(fit);
    const term = new Terminal({windowsMode: true});
    term.open(document.getElementById('log-container'));
    term.fit();

    var lastResponseLength = false;
    $.ajax({
        type: 'GET',
        url: '/src/restclient/ContainerClient.php',
        data: {
            'container-id': containerId,
            'operation': 'CHECK'
        },
        xhrFields: {
            onprogress: function (e) {
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
        .done(function (data) {
            console.log('Complete response = ' + data);
        })
        .fail(function (data) {
            console.log('Error: ', data);
        });
}