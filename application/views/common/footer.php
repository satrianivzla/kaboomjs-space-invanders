</div>
        <!-- Sidebar Widgets Column -->
        <div class="col-md-4">
            <!-- Search Widget -->
            <div class="card my-4">
                <h5 class="card-header">Search</h5>
                <div class="card-body">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                            <button class="btn btn-secondary" type="button">Go!</button>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Ad Widget -->
            <div class="card my-4">
                <h5 class="card-header">Advertisement</h5>
                <div class="card-body">
                    <?php echo display_ad('sidebar'); ?>
                </div>
            </div>
            <!-- Categories Widget -->
            <div class="card my-4">
                <h5 class="card-header">Categories</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="list-unstyled mb-0">
                                <li><a href="#">Web Design</a></li>
                                <li><a href="#">HTML</a></li>
                                <li><a href="#">Freebies</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <ul class="list-unstyled mb-0">
                                <li><a href="#">JavaScript</a></li>
                                <li><a href="#">CSS</a></li>
                                <li><a href="#">Tutorials</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /.container -->

<!-- Footer -->
<footer class="py-5 bg-dark mt-4">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; JulesBlog <?php echo date('Y'); ?></p>
    </div>
    <!-- /.container -->
</footer>

<!-- Bootstrap core JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>

<!-- WhatsApp floating button -->
<style>
.whatsapp-float {
    position: fixed;
    width: 60px;
    height: 60px;
    bottom: 40px;
    right: 40px;
    background-color: #25d366;
    color: #FFF;
    border-radius: 50px;
    text-align: center;
    font-size: 30px;
    box-shadow: 2px 2px 3px #999;
    z-index: 100;
}
.whatsapp-float:hover {
    color: #FFF;
}
.my-float {
    margin-top: 16px;
}
</style>
<a href="https://wa.me/<?php echo $this->config->item('whatsapp_number'); ?>" class="whatsapp-float" target="_blank">
    <i class="fa fa-whatsapp my-float"></i> <!-- Font Awesome icon -->
</a>

</body>
</html>
