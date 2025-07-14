<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1><?php echo $title; ?></h1>
                <a href="<?php echo site_url('admin/posts/create'); ?>" class="btn btn-primary">Add New Post</a>
            </div>

            <div class="card">
                <div class="card-body">
                    <table id="posts-table" class="table table-striped table-bordered datatable" style="width:100%">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($posts)): ?>
                                <?php foreach ($posts as $post): ?>
                                    <tr>
                                        <td><?php echo html_escape($post['title']); ?></td>
                                        <td><?php echo html_escape($post['first_name'] . ' ' . $post['last_name']); ?></td>
                                        <td>
                                            <span class="badge <?php echo $post['status'] == 'published' ? 'bg-success' : 'bg-secondary'; ?>">
                                                <?php echo ucfirst($post['status']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo date('Y-m-d H:i', strtotime($post['created_at'])); ?></td>
                                        <td>
                                            <a href="<?php echo site_url('admin/posts/edit/' . $post['id']); ?>" class="btn btn-sm btn-info">Edit</a>
                                            <a href="<?php echo site_url('admin/posts/delete/' . $post['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">No posts found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
