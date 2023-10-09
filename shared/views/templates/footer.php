    <!-- Enable console: Eruda for mobile -->
    <!--<script src="//cdn.jsdelivr.net/npm/eruda"></script>-->
    <!--<script>eruda.init();</script>-->
    
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script src="<?= BASEURL . '/' . SHARED_DIR ?>/assets/js/main.js"></script>
    <?= isset($data["appScript"]) ? $data["appScript"] : "" ?>
</body>
</html>