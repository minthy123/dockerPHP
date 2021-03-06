<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th><a href="">IMAGE</a></th>
            <th><a href="">CREATED</a></th>
            <th><a href="">CREATED BY</a></th>
            <th><a href="">SIZE</a></th>
            <th><a href="">COMMENT</a></th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach ($GLOBALS['image']->getHistories() as $imageHistory) {
                echo "<tr>\n";
                echo "<td class='wrap-td'>". substr($imageHistory->getId(), 0, 12)."</a></td>\n";
                echo "<td class='wrap-td'>".date("Y-m-d H:i:s", $imageHistory->getCreatedSince())."</td>\n";
                echo "<td class='wrap-td'>".$imageHistory->getCreatedBy()."</td>\n";
                echo "<td class='wrap-td'>".$imageHistory->getSize()."</td>\n";
                echo "<td class='wrap-td'>".$imageHistory->getTag()."</td>\n";
                echo "</tr>\n";
            }
        ?>
    </tbody>

    <script>
        $('.wrap-td').each(function () {
            var text = $(this).text();

            const LENGTH_TRIM = 50;

            if (text.length >= LENGTH_TRIM) {
                $(this).attr('data-toggle', 'tooltip')
                    .attr('data-placement', 'top')
                    .attr('title', text)
                    .text($.trim(text).substring(0, LENGTH_TRIM) + "...");
            }
        });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

</table>