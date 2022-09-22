<?php
    function copyFunction($text) { ?>
        <script>
            function copyRecords() {
                var copyText = <?= "\"WSAP Internship Portal: https://wsapinternshipportal.com/\\n\\n\" +\n".$text; ?>;
                navigator.clipboard.writeText(copyText.trim());
                alert("The records are copied to clipboard.");
            }
        </script> <?php
    }
?>