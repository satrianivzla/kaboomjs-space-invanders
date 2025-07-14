<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1><?php echo $title; ?></h1>
            <p>Paste the full text for a day's events below. The system will automatically parse the text, identify categories (like "Nacimientos:", "Fallecimientos:", etc.), and create a separate post for each entry under the correct category.</p>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <?php echo form_open('admin/dailyentry/store'); ?>
                        <div class="mb-3">
                            <label for="daily_text" class="form-label">Daily Events Text</label>
                            <textarea class="form-control" id="daily_text" name="daily_text" rows="20" placeholder="Paste the text here..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Posts</button>
                        <a href="<?php echo site_url('admin/posts'); ?>" class="btn btn-secondary">Cancel</a>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
