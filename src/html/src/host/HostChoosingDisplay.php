<select class="selectpicker" data-style="select-with-transition" title="Choose host" data-size="7" onchange="addHostParam(this.value)">
    <?php
        foreach ($hosts as $host) {
            $name = $host->getName().' ('.$host->getIp().':'.$host->getPort().')';
            $selected = $chosenHost == $host ? "selected" : "";

            echo "<option $selected value='".$host->getId()."'> ". $name."</option>";
        }
     ?>
</select>
<script type="text/javascript">
    function addHostParam(value) {
        // $( "#here" ).load(window.location.href + "?host-id=" + value+"#here");
        if (!window.location.href.includes("host-id=")) {
            window.location.href = window.location.href + "?host-id=" +value;
        } else {
            window.location.href = window.location.href.replace(/host-id=\d+/, "host-id=" + value);
        }
    }
</script>