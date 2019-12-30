function checkLogContainer(containerId, hostId) {
    Terminal.applyAddon(fit);
    const term = new Terminal({windowsMode: true});
    term.open(document.getElementById('log-container'));
    term.fit();

    var lastResponseLength = false;
    $.ajax({
        type: 'GET',
        url: '/src/service/ContainerService.php',
        data: {
            'operation': 'CHECK',
            'container-id': containerId,
            'host-id': hostId
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

$('#log-1').click(function (e) {
    e.preventDefault();
    if ($(this).hasClass('processing')) return;
    $(this).addClass('processing');
    setTimeout(function(){
        checkLogContainer($.urlParam("container-id"), $.urlParam("host-id"))}, 1);
});