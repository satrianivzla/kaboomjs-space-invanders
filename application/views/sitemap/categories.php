<?php echo '<?xml version="1.0" encoding="UTF-8" ?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php foreach($categories as $category) { ?>
    <url>
        <loc><?php echo site_url('en/category/' . $category['slug']); ?></loc>
        <changefreq>weekly</changefreq>
        <priority>0.6</priority>
    </url>
     <url>
        <loc><?php echo site_url('es/category/' . $category['slug']); ?></loc>
        <changefreq>weekly</changefreq>
        <priority>0.6</priority>
    </url>
    <?php } ?>
</urlset>
