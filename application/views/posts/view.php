<?php $this->load->view('common/header', $post); ?>

<!-- Post Content -->
<article>
    <h1 class="mt-4"><?php echo html_escape($post['title_' . $current_lang]); ?></h1>
    <p class="lead">
        by <a href="#"><?php echo html_escape($post['first_name'] . ' ' . $post['last_name']); ?></a>
    </p>
    <hr>
    <p>Posted on <?php echo date('F j, Y, g:i a', strtotime($post['created_at'])); ?></p>
    <hr>
    <?php if ($post['featured_image']): ?>
        <img class="img-fluid rounded" src="<?php echo base_url('uploads/images/' . $post['featured_image']); ?>" alt="<?php echo html_escape($post['title_en']); ?>">
        <hr>
    <?php endif; ?>

    <?php echo $post['content_' . $current_lang]; ?>
</article>

<hr>

<!-- Comments Form -->
<div class="card my-4">
    <h5 class="card-header">Leave a Comment:</h5>
    <div class="card-body">
        <form>
            <div class="form-group">
                <textarea class="form-control" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

<?php $this->load->view('common/footer'); ?>
