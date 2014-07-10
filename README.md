Wordpress Corcel
================

This package helps you integrate wordpress with your laravel installation.

Let's say you dropped your wordpress at *public/wordpress* and http://xyz.com/wordpress open wordpress blog. But, may be, may be for some crazy reason you want use your Laravel routes and controllers to show off the blog, let's say at http://xyz.com/blog! This way you can control the look, add blogs to any other pages, access that database all the while using wordpress admin.

Of course you can use Raw DB Statements to do this! But, What's fun in that! Corcel gives you Eloquent Classes to do that!

*Corcel is under development.*

Credit goes to Junior Grossi for starting this!

I have extended some of the functionality. 

--

Corcel is a class collection created to retrieve Wordpress database data using a better syntax. It uses the Eloquent ORM developed for the Laravel Framework, but you can use Corcel in any type of PHP project.

This way you can use Wordpress as back-end, to insert posts, custom types, etc, and you can use what you want in front-end, like Silex, Slim Framework, Laravel, Zend, or even pure PHP (why not?).

## Installation

To install Corcel just create a `composer.json` file and add:

    "require": {
        "rajivseelam/corcel": "dev-master"
    },

Include the following in your public/index.php (So that we can WP functions)

    define('WP_USE_THEMES', false);
    require __DIR__.'/wordpress/wp-blog-header.php';

After that run `composer install` and wait.

## Connecting to DB

You needn't do this if you are using WP along with Laravel.

First you must include the Composer `autoload` file.

    require __DIR__ . '/vendor/autoload.php';

Now you must set your Wordpress database params:

    $params = array(
        'database'  => 'database_name',
        'username'  => 'username',
        'password'  => 'pa$$word',
    );
    Corcel\Database::connect($params);

You can specify all Eloquent params, but some are default (but you can override them).

    'driver'    => 'mysql',
    'host'      => 'localhost',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',

## Usage

### Posts

    // All published posts
    $posts = Post::published()->get();
    $posts = Post::status('publish')->get();

    // A specific post
    $post = Corcel\Post::find(31);
    echo $post->post_title;
    
    // A specific post by slug
    $post = Corcel\Post::slug($slug)->first();

You can retrieve meta data from posts too.

    // Get a custom meta value (like 'link' or whatever) from a post (any type)
    $post = Corcel\Post::find(31);
    echo $post->meta->link; // OR
    echo $post->link;
    
    //Categories or Tags of a post
    $post->categories(); 
    
    $post->tags();
    
    //Get thumbnail url
    $post->thumbnail_url();
    
    //Get the large version
    $post->thumbnail_url('large');
    
    //Find posts under a category
    
    $category = Corcel\Category::where('slug',$slug)->first();

    $posts = $category->posts();
    
        
    //Find posts under a tag
    
    $tag = Corcel\Tag::where('slug',$slug)->first();

    $posts = $tag->posts();

### Categories and Tags

    // Get all categories
    
    $categories = Corcel\Category::all();
    

### Custom Post Type

You can work with custom post types too. You can use the `type(string)` method or create your own class.

    // using type() method
    $videos = Post::type('video')->status('publish')->get();

    // using your own class
    class Video extends Corcel\Post
    {
        protected $postType = 'video';
    }
    $videos = Video::status('publish')->get();

Custom post types and meta data.

    // Get 3 posts with custom post type (store) and show its title
    $stores = Post::type('store')->status('publish')->take(3)->get();
    foreach ($stores as $store) {
        $storeAddress = $store->address;
    }

### Pages

Pages are like custom post types. You can use `Post::type('page')` or the `Page` class:

    // Find a page by slug
    $page = Page::slug('about')->first(); // OR
    $page = Post::type('page')->slug('about')->first();
    echo $page->post_title;

### More

Dig through the code to find more!

## Licence

Corcel is licensed under the MIT license.
