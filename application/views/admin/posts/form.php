<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1><?php echo $title; ?></h1>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <?php echo form_open_multipart(isset($post) ? 'admin/posts/update/' . $post['id'] : 'admin/posts/store'); ?>
                <div class="card mb-3">
                    <div class="card-header">Post Content</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="<?php echo set_value('title', isset($post) ? $post['title'] : ''); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control ckeditor" id="content" name="content" rows="10"><?php echo set_value('content', isset($post) ? $post['content'] : ''); ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header">SEO</div>
                    <div class="card-body">
                         <div class="mb-3">
                            <label for="seo_title" class="form-label">SEO Title</label>
                            <input type="text" class="form-control" id="seo_title" name="seo_title" value="<?php echo set_value('seo_title', isset($post) ? $post['seo_title'] : ''); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="seo_description" class="form-label">SEO Description</label>
                            <textarea class="form-control" id="seo_description" name="seo_description" rows="3"><?php echo set_value('seo_description', isset($post) ? $post['seo_description'] : ''); ?></textarea>
                        </div>
                    </div>
                </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">Publish</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="draft" <?php echo set_select('status', 'draft', isset($post) && $post['status'] == 'draft'); ?>>Draft</option>
                            <option value="published" <?php echo set_select('status', 'published', isset($post) && $post['status'] == 'published'); ?>>Published</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Post</button>
                    <a href="<?php echo site_url('admin/posts'); ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">Featured Image</div>
                <div class="card-body">
                    <input type="file" class="form-control" name="featured_image" id="featured_image">
                    <?php if (isset($post) && $post['featured_image']): ?>
                        <img src="<?php echo base_url('uploads/images/' . $post['featured_image']); ?>" alt="Featured Image" class="img-fluid mt-2">
                    <?php endif; ?>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">Categories</div>
                <div class="card-body" style="max-height: 200px; overflow-y: auto;">
                    <?php foreach ($categories as $category): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="categories[]" value="<?php echo $category['id']; ?>" id="cat_<?php echo $category['id']; ?>" <?php echo set_checkbox('categories[]', $category['id'], isset($post_categories) && in_array($category['id'], $post_categories)); ?>>
                            <label class="form-check-label" for="cat_<?php echo $category['id']; ?>">
                                <?php echo html_escape($category['name']); ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Tags</div>
                <div class="card-body">
                    <input type="text" class="form-control" name="tags" id="tags" value="<?php echo set_value('tags', isset($post_tags) ? implode(', ', $post_tags) : ''); ?>" placeholder="Comma-separated tags">
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
