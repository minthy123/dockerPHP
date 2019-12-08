
Download file:
<form method="get" action="/src/service/ContainerService.php" target="_blank">
    <input type="text" name="path" placeholder="Input path">
    <input type="hidden" name="container-id" value="<?php echo $GLOBALS['container']->getId()?>">
    <input type="submit" name="submit">
</form>


<br>
<br>
Upload file:
<form method="post" action="/src/service/ContainerService.php" target="_blank" enctype="multipart/form-data">
    <input type="text" name="path" placeholder="Input path"><br>
    <input type="file" name="uploadFile"><br>
    <input type="hidden" name="container-id" value="<?php echo $GLOBALS['container']->getId()?>">
    <input type="submit" name="submit">
</form>
