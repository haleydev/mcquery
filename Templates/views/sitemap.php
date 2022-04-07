<?php  
    header("Content-type: text/xml");
    echo '<?xml version="1.0" encoding="UTF-8" ?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?=URL?></loc>        
        <lastmod>2022-01-03</lastmod>
        <priority>1.0</priority>
    </url>

    <?php            
        // foreach($this->data[1] as $sitemap){
        // echo
        // "<url>
        //     <loc>https://yousite/post?p=".$sitemap['name']."</loc>        
        //     <lastmod>".$sitemap['data']."</lastmod>
        //     <priority>1.0</priority>
        // </url>";
        // }          
    ?>
</urlset>