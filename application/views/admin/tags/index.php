<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1><?php echo $title; ?></h1>
                <a href="<?php echo site_url('admin/tags/create'); ?>" class="btn btn-primary">Add New Tag</a>
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
                            <?php foreach ($tags as $tag): ?>
                                <tr>
                                    <td><?php echo $tag['id']; ?></td>
                                    <td><?php echo html_escape($tag['name']); ?></td>
                                    <td><?php echo $tag['slug']; ?></td>
                                    <td>
                                        <a href="<?php echo site_url('admin/tags/edit/' . $tag['id']); ?>" class="btn btn-sm btn-info">Edit</a>
                                        <a href="<?php echo site_url('admin/tags/delete/' . $tag['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this tag?');">Delete</a>
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
