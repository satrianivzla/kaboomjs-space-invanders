</main>
    </div>
</div>

<footer class="footer mt-auto py-3 bg-light">
    <div class="container">
        <span class="text-muted">JulesBlog Admin Panel &copy; <?php echo date('Y'); ?></span>
    </div>
</footer>

<!-- jQuery (necessary for Bootstrap's and DataTables' JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap 5 JS Bundle -->
<script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>

<!-- DataTables JS -->
<script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>

<!-- CKEditor JS -->
<script src="<?php echo base_url('assets/plugins/ckeditor/ckeditor.js'); ?>"></script>

<!-- Custom script to initialize plugins -->
<script>
$(document).ready(function() {
    // Initialize DataTables on any table with the class 'datatable'
    $('.datatable').DataTable();

    // Initialize CKEditor on any textarea with the class 'ckeditor'
    // Note: CKEditor automatically transforms textareas with the 'ckeditor' class
    // if the script is loaded. For more specific configuration, we can use:
    if (document.querySelector('.ckeditor')) {
        CKEDITOR.replace('content', { // Assuming the textarea has id='content'
            // Add any custom CKEditor configuration here
            // For example: height: 400
        });
    }
});
</script>

</body>
</html>
