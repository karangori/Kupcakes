//for logout
<?php
session_start();
session_destroy();
echo "<script>location.href='menu.php'</script>";
?>
