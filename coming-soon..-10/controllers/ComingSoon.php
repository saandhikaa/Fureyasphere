<?php
    class ComingSoon extends Controller {
        public function index() {
            echo '<script type="text/javascript">
                alert("Other applications are coming soon...");
                window.location.href = "' . BASEURL . '";
            </script>'; 
        }
    }
?>