<?php
$protocol =  $_SERVER["REQUEST_SCHEME"] === 'http' ? 'http' : 'https';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';


$scripr_dir = dirname($_SERVER['SCRIPT_NAME']);
$explode_str = explode('/', $scripr_dir);
$base_path = '/' . $explode_str[1];

define("BASE_URL", $protocol . '://' . $host . $base_path);
define("ASSETS_URL", BASE_URL . "/assets");
define('CSS_URL', ASSETS_URL . '/css');
define('JS_URL', ASSETS_URL . '/js');
define('IMG_URL', ASSETS_URL . '/images');

//navigation links
define("NAV_LINKS", [
    [
        'name' => "Home",
        'link' => "#"
    ],
    [
        'name' => "Shop",
        'link' => "#"
    ],
    [
        'name' => "Pages",
        'link' => "#"
    ],
    [
        'name' => "Blog",
        'link' => "#"
    ],
    [
        'name' => "About Us",
        'link' => "#"
    ],
    [
        'name' => "Contact US",
        'link' => "#"
    ],

]);


// Breadcrumbs

class BreadCrumb
{

    private $items = []; // stores all breadcrumbs entries (each being title and an optional utl);

    // method to add breadcrumb
    public function add($title, $url = null)
    {
        $this->items[] = [
            'title' => $title,
            'url' => $url
        ];
        return $this; // this returns the current object to allow method chaining
    }

    // method to render the html
    public function render($seperator = '>')
    {
        if (empty($this->items)) {
            return '';
        }

        $html = '<nav class="breadcrumb">';
        $count = count($this->items); //Stores the total number of breadcrumb items — used to detect the last one.
        foreach ($this->items as $index => $item) {
            $is_last = $index === $count - 1;
            /**Checks if this is the last breadcrumb in the list (the current page).The last item shouldn’t be a clickable link. */

            if ($index > 0) {
                $html .= ' <span class="separator">' . $seperator . '</span> ';
            }
            if ($is_last || empty($item['url'])) {
                $html .= ' <span classs="current">' . htmlspecialchars($item['title']) . '</span>';
            } else {
                $html .= '<a href="' . htmlspecialchars($item['url']) . '">' . htmlspecialchars($item['title']) . '</a>';
            }
        }
        $html .= '</nav>';
        return $html;
    }
    // Generate Schema.org structured data
    public function renderSchema()
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => []
        ];

        foreach ($this->items as $index => $item) {
            if (!empty($item['url'])) {
                $schema['itemListElement'][] = [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'name' => $item['title'],
                    'item' => $item['url']
                ];
            }
        }

        return '<script type="application/ld+json">' .
            json_encode($schema, JSON_UNESCAPED_SLASHES) .
            '</script>';
    }
}
