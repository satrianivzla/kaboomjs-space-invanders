<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1><?php echo $title; ?></h1>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <?php echo form_open(isset($ad) ? 'admin/ads/update/' . $ad['id'] : 'admin/ads/store'); ?>
                        <div class="mb-3">
                            <label for="name" class="form-label">Ad Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name', isset($ad) ? $ad['name'] : ''); ?>" required>
                            <small class="form-text text-muted">A descriptive name for internal use (e.g., "Sidebar Amazon Ad").</small>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" name="location" value="<?php echo set_value('location', isset($ad) ? $ad['location'] : ''); ?>" required>
                             <small class="form-text text-muted">Where the ad will be displayed (e.g., "sidebar", "post_header").</small>
                        </div>
                        <div class="mb-3">
                            <label for="ad_code" class="form-label">Ad Code</label>
                            <textarea class="form-control" id="ad_code" name="ad_code" rows="10" required><?php echo set_value('ad_code', isset($ad) ? $ad['ad_code'] : ''); ?></textarea>
                            <small class="form-text text-muted">Paste the full ad code from your provider (e.g., Amazon, Google AdSense).</small>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" <?php echo set_checkbox('is_active', '1', isset($ad) ? $ad['is_active'] : TRUE); ?>>
                            <label class="form-check-label" for="is_active">
                                Active
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Advertisement</button>
                        <a href="<?php echo site_url('admin/ads'); ?>" class="btn btn-secondary">Cancel</a>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
