<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1><?php echo $title; ?></h1>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <?php echo form_open(isset($category) ? 'admin/categories/update/' . $category['id'] : 'admin/categories/store'); ?>
                        <div class="mb-3">
                            <label for="name_en" class="form-label">Category Name (EN)</label>
                            <input type="text" class="form-control" id="name_en" name="name_en" value="<?php echo set_value('name_en', isset($category) ? $category['name_en'] : ''); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="name_es" class="form-label">Category Name (ES)</label>
                            <input type="text" class="form-control" id="name_es" name="name_es" value="<?php echo set_value('name_es', isset($category) ? $category['name_es'] : ''); ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Save Category</button>
                        <a href="<?php echo site_url('admin/categories'); ?>" class="btn btn-secondary">Cancel</a>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
