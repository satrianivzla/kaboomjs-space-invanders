<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1><?php echo $title; ?></h1>
                <a href="<?php echo site_url('admin/categories/create'); ?>" class="btn btn-primary">Add New Category</a>
            </div>

            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-bordered datatable" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td><?php echo $category['id']; ?></td>
                                    <td><?php echo html_escape($category['name']); ?></td>
                                    <td><?php echo $category['slug']; ?></td>
                                    <td>
                                        <a href="<?php echo site_url('admin/categories/edit/' . $category['id']); ?>" class="btn btn-sm btn-info">Edit</a>
                                        <a href="<?php echo site_url('admin/categories/delete/' . $category['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this category?');">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
