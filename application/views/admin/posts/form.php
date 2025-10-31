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
                <!-- Language Tabs -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="en-tab" data-bs-toggle="tab" data-bs-target="#en-content" type="button" role="tab" aria-controls="en-content" aria-selected="true">English</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="es-tab" data-bs-toggle="tab" data-bs-target="#es-content" type="button" role="tab" aria-controls="es-content" aria-selected="false">Spanish</button>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    <!-- English Content -->
                    <div class="tab-pane fade show active" id="en-content" role="tabpanel" aria-labelledby="en-tab">
                        <div class="card mb-3 border-top-0">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="title_en" class="form-label">Title (EN)</label>
                                    <input type="text" class="form-control" id="title_en" name="title_en" value="<?php echo set_value('title_en', isset($post) ? $post['title_en'] : ''); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="content_en" class="form-label">Content (EN)</label>
                                    <textarea class="form-control ckeditor" id="content_en" name="content_en" rows="10"><?php echo set_value('content_en', isset($post) ? $post['content_en'] : ''); ?></textarea>
                                </div>
                                 <div class="mb-3">
                                    <label for="seo_title_en" class="form-label">SEO Title (EN)</label>
                                    <input type="text" class="form-control" id="seo_title_en" name="seo_title_en" value="<?php echo set_value('seo_title_en', isset($post) ? $post['seo_title_en'] : ''); ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="seo_description_en" class="form-label">SEO Description (EN)</label>
                                    <textarea class="form-control" id="seo_description_en" name="seo_description_en" rows="3"><?php echo set_value('seo_description_en', isset($post) ? $post['seo_description_en'] : ''); ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Spanish Content -->
                    <div class="tab-pane fade" id="es-content" role="tabpanel" aria-labelledby="es-tab">
                        <div class="card mb-3 border-top-0">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="title_es" class="form-label">Title (ES)</label>
                                    <input type="text" class="form-control" id="title_es" name="title_es" value="<?php echo set_value('title_es', isset($post) ? $post['title_es'] : ''); ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="content_es" class="form-label">Content (ES)</label>
                                    <textarea class="form-control ckeditor" id="content_es" name="content_es" rows="10"><?php echo set_value('content_es', isset($post) ? $post['content_es'] : ''); ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="seo_title_es" class="form-label">SEO Title (ES)</label>
                                    <input type="text" class="form-control" id="seo_title_es" name="seo_title_es" value="<?php echo set_value('seo_title_es', isset($post) ? $post['seo_title_es'] : ''); ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="seo_description_es" class="form-label">SEO Description (ES)</label>
                                    <textarea class="form-control" id="seo_description_es" name="seo_description_es" rows="3"><?php echo set_value('seo_description_es', isset($post) ? $post['seo_description_es'] : ''); ?></textarea>
                                </div>
                            </div>
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
