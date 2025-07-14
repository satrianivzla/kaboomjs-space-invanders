<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1><?php echo $title; ?></h1>
                <a href="<?php echo site_url('admin/ads/create'); ?>" class="btn btn-primary">Add New Ad</a>
            </div>

            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-bordered datatable" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Location</th>
                                <th>Active</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ads as $ad): ?>
                                <tr>
                                    <td><?php echo $ad['id']; ?></td>
                                    <td><?php echo html_escape($ad['name']); ?></td>
                                    <td><?php echo html_escape($ad['location']); ?></td>
                                    <td>
                                        <span class="badge <?php echo $ad['is_active'] ? 'bg-success' : 'bg-secondary'; ?>">
                                            <?php echo $ad['is_active'] ? 'Yes' : 'No'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?php echo site_url('admin/ads/edit/' . $ad['id']); ?>" class="btn btn-sm btn-info">Edit</a>
                                        <a href="<?php echo site_url('admin/ads/delete/' . $ad['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this advertisement?');">Delete</a>
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
