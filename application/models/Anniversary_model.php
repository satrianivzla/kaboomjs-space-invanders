<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anniversary_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        // It's good practice to load the HTTP client library if CodeIgniter has one,
        // or ensure cURL is available if planning to use it directly.
        // For CI3, there isn't a dedicated HTTP client library like in CI4.
        // We might use file_get_contents with stream contexts or cURL.
    }

    /**
     * Fetches the raw HTML content from the specified URL.
     *
     * @param string $url The URL to fetch content from.
     * @return string|false The HTML content as a string, or false on failure.
     */
    public function fetch_blog_content($url) {
        // Using file_get_contents for simplicity.
        // For more complex scenarios (headers, POST requests, error handling), cURL would be better.
        $context_options = [
            "ssl" => [
                "verify_peer" => false, // Not recommended for production, but helps with potential SSL issues on some servers
                "verify_peer_name" => false,
            ],
            "http" => [
                "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36\r\n"
            ]
        ];
        $context = stream_context_create($context_options);
        $html_content = @file_get_contents($url, false, $context);

        if ($html_content === FALSE) {
            log_message('error', 'Anniversary_model: Failed to fetch content from URL: ' . $url);
            return false;
        }
        return $html_content;
    }

    /**
     * Parses the HTML content to extract music anniversary data.
     * This is a placeholder and will need significant implementation
     * based on the actual structure of efemeridesrockmetal.blogspot.com.
     *
     * @param string $html_content The HTML content to parse.
     * @return array An array of anniversary data.
     */
    public function parse_anniversaries($html_content) {
        if (empty($html_content)) {
            return array();
        }

        $anniversaries = array();
        $dom = new DOMDocument();

        // Suppress errors from invalid HTML structure on the blog
        @$dom->loadHTML($html_content);

        $xpath = new DOMXPath($dom);

        // --- !!! IMPORTANT !!! ---
        // The following XPath query is a GUESS. It needs to be inspected and
        // adjusted based on the actual HTML structure of the target blog.
        // For example, if anniversaries are in <div class="post-body"> then <li> items:
        // $nodes = $xpath->query('//div[contains(@class, "post-body")]//li');
        // Or if they are in <div class="entry-content"> inside <article> tags:
        // $nodes = $xpath->query('//article//div[contains(@class, "entry-content")]//p');
        // Or direct <p> tags within a main content area.

        // Let's assume for now each anniversary entry is a <p> tag inside a specific div.
        // This will need to be refined after inspecting the blog's HTML.
        // For demonstration, let's try to find all <p> tags within a common blog post container.
        // A common class for blog post content is 'post-body' or 'entry-content'.
        // We need to inspect the actual blog to confirm this.

        // Example: Query for all paragraphs within elements with class 'post-body'
        // $query = '//div[contains(@class, "post-body")]//p';
        // For now, let's make a more generic query to see what we get,
        // then refine it. This is highly dependent on the blog's structure.
        // We'll need to inspect the blog's HTML to create the correct XPath query.
        // Based on common Blogger structures and the text view, entries are likely <p> tags
        // within a main post content area. A common class for this is 'post-body entry-content'
        // or just 'post-body'.
        // We will look for <p> tags directly within such a div.
        // This query attempts to find <p> elements that are children of a <div>
        // whose class attribute contains 'post-body'.
        $query = '//div[contains(@class, "post-body")]/p | //div[contains(@class, "entry-content")]/p | //div[contains(@class, "post-body")]//p[normalize-space()]';
        // The normalize-space() is to ensure we get paragraphs with actual text content.
        // The third part //div[contains(@class, "post-body")]//p is broader if they are nested deeper.

        $nodes = $xpath->query($query);
        $potential_dates = ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"];

        if ($nodes && $nodes->length > 0) {
            foreach ($nodes as $node) {
                $text = trim(preg_replace('/\s+/', ' ', $node->nodeValue));

                // Basic filter: try to identify if the text starts with a date pattern
                // e.g., "DD de MMMM de YYYY." or "DD de MMMM."
                // This is a heuristic and might need refinement.
                $is_event = false;
                foreach ($potential_dates as $month) {
                    if (preg_match('/^\d{1,2} de ' . $month . '/i', $text)) {
                        $is_event = true;
                        break;
                    }
                }
                // Also check for "MAS EFEMÉRIDES" section items which might not have full date
                if (preg_match('/^\d{4} - /', $text) && !$is_event) { // e.g. "1963 - Los Beatles..."
                     //This might be too broad, let's see.
                }


                if ($is_event && !empty($text)) {
                    // Further parsing can be done here to extract date, event details, etc.
                    // For now, just taking the raw text.
                    $anniversaries[] = array(
                        'raw_text' => $text,
                        // 'date_event' => extracted_date, // Placeholder
                        // 'description' => extracted_description // Placeholder
                    );
                }
            }
        } else {
             // Fallback or broader query if the specific one fails.
             // This is risky as it might grab unwanted <p> tags.
             // log_message('debug', 'Anniversary_model: Initial XPath query yielded no results. Trying a broader query for all <p> tags.');
             // $nodes = $xpath->query('//p[normalize-space()]');
             // foreach ($nodes as $node) {
             //    $text = trim(preg_replace('/\s+/', ' ', $node->nodeValue));
             //    // Apply the same heuristic
             //    $is_event = false;
             //    foreach ($potential_dates as $month) {
             //        if (preg_match('/^\d{1,2} de ' . $month . '/i', $text)) {
             //            $is_event = true;
             //            break;
             //        }
             //    }
             //    if ($is_event && !empty($text)) {
             //        $anniversaries[] = array('raw_text' => $text);
             //    }
            // }
        }

        if (empty($anniversaries)) {
            log_message('debug', 'Anniversary_model: No anniversary items found. The XPath query and parsing logic might need significant adjustment based on the exact blog HTML structure.');
        }

        return $anniversaries;
    }

    /**
     * A public method to get all anniversaries.
     * It fetches and then parses.
     */
    public function get_all_anniversaries() {
        $blog_url = 'https://efemeridesrockmetal.blogspot.com/'; // The target URL
        $html_content = $this->fetch_blog_content($blog_url);

        if (!$html_content) {
            return array(); // Return empty if fetching failed
        }

        return $this->parse_anniversaries($html_content);
    }
}
?>
