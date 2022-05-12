
    <div class="admin-foots">
        <a href="#" class="mm-translations--btn btn btn-success btn-circle waves-effect waves-circle waves-float">
            <i class="material-icons">translate</i>
        </a>
    </div>
    <!-- Bootstrap Core Js -->
    <script src="<?php echo adminUrl('themes/material/plugins/bootstrap/js/bootstrap.js'); ?>"></script>

    <!-- Select Plugin Js -->
    <script src="<?php echo adminUrl('themes/material/plugins/bootstrap-select/js/bootstrap-select.js'); ?>"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="<?php echo adminUrl('themes/material/plugins/jquery-slimscroll/jquery.slimscroll.js'); ?>"></script>

    <!-- Autosize Plugin Js -->
    <script src="<?php echo adminUrl('themes/material/plugins/autosize/autosize.js'); ?>"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo adminUrl('themes/material/plugins/node-waves/waves.js'); ?>"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="<?php echo adminUrl('themes/material/plugins/jquery-countto/jquery.countTo.js'); ?>"></script>

    <!-- Morris Plugin Js -->
    <script src="<?php echo adminUrl('themes/material/plugins/raphael/raphael.min.js'); ?>"></script>
    <script src="<?php echo adminUrl('themes/material/plugins/morrisjs/morris.js'); ?>"></script>

    <!-- Custom Js -->
	<?php
        doAction('adminScripts');
    ?>
    <script src="<?php echo adminUrl('themes/material/js/admin.js'); ?>"></script>
    <script src="<?php echo adminUrl('themes/material/js/pages/index.js'); ?>"></script>

    <?php
        if(! empty(getSession('redirect'))) {
            notifyMsg(getSession('redirect'));
        }
    ?>
</body>

</html>