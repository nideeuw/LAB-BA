<!-- [ Main Content ] end -->
    <footer class="pc-footer">
        <div class="footer-wrapper container-fluid">
            <div class="row">
                <div class="col my-1">
                    <p class="m-0">
                        Lab BA &copy; <?php echo date('Y'); ?> Made with ❤️ by Your Team
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Required Js -->
    <script src="<?php echo $base_url; ?>/assets/js/plugins/popper.min.js"></script>
    <script src="<?php echo $base_url; ?>/assets/js/plugins/simplebar.min.js"></script>
    <script src="<?php echo $base_url; ?>/assets/js/plugins/bootstrap.min.js"></script>
    <script src="<?php echo $base_url; ?>/assets/js/fonts/custom-font.js"></script>
    <script src="<?php echo $base_url; ?>/assets/js/pcoded.js"></script>
    <script src="<?php echo $base_url; ?>/assets/js/plugins/feather.min.js"></script>
    
    <!-- [Page Specific JS] start -->
    <?php if(isset($page_scripts)): ?>
        <?php echo $page_scripts; ?>
    <?php endif; ?>
    <!-- [Page Specific JS] end -->

</body>
<!-- [Body] end -->
</html>