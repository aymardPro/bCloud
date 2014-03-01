<?php
    header('Content-Disposition: attachment; filename="mypdf-'.date("n-d-Y").'.pdf"');
    header("Content-type: application/pdf");
    header('Cache-Control: private, max-age=0, must-revalidate');
    header('Pragma: public');
    echo $content_for_layout;
?>