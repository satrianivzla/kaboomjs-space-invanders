<?php echo '<?xml version="1.0" encoding="UTF-8" ?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php foreach($posts as $post) { ?>
    <url>
        <loc><?php echo site_url('en/posts/view/' . $post['slug']); ?></loc>
        <lastmod><?php echo date('Y-m-d', strtotime($post['updated_at'])); ?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc><?php echo site_url('es/posts/view/' . $post['slug']); ?></loc>
        <lastmod><?php echo date('Y-m-d', strtotime($post['updated_at'])); ?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <?php } ?>
</urlset>
