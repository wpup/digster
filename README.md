# Digster

[![Build Status](https://travis-ci.org/wpup/digster.svg?branch=master)](https://travis-ci.org/wpup/digster)

> Twig templates for WordPress

Digster it's a WordPress plugin that allows you to render Twig views with a
few Twig [filters](#twig-filters), [functions](#twig-functions) and [globals](#twig-globals).

It's easy to register your own [extensions](#register-extension) or [composers](#register-composer).

## Install

```
composer require frozzare/digster
```

## Example

Example of `page.php`

```php
/**
 * Render page view.
 */
echo view( 'page' );
```

Example of `page.twig`

```jinja
{% include "partials/header.twig" %}
<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<article class="post-2 page type-page status-publish hentry">
			<header class="entry-header">
				<h1 class="entry-title">{{ post.post_title }}</h1>
			</header>
			<div class="entry-content">
				{{ post.post_content | wpautop | raw }}
			</div>
		</article>
	</main>
</div>
{% include "partials/footer.twig" %}
```

## Configuration

Digster has a few WordPress filters, one is the config filter. Debug is turn on by default if `WP_ENV` equals `development`

```php
add_filter( 'digster/config', function ( $config ) {
  return $config;
} );
```

#### Locations

A array with the locations of the views. By default
the `get_templates_directory() . '/views'` is registered.

```php
add_filter( 'digster/config', function ( $config ) {
  $config['locations'] = 'path/to/locations';
  return $config;
} );
```

#### Twig environment options

Read about the options on the [Twig site](http://twig.sensiolabs.org/doc/api.html#environment-options)

`auto_reload` example
```php
add_filter( 'digster/config', function ( $config ) {
  $config['auto_reload'] = true;
  return $config;
} );
```

## API functions

All functions that has `digster_` prefix can also be called as a static method on `\Frozzare\Digster\Digster` class. Just replace `digster_` with `Digster::`, make sure that you have in your code `use Frozzare\Digster\Digster`

##### Fetch view

Fetch the view in to a string.

```php
$view = digster_fetch( 'page' [, $data = [] ] );
```

#### Get the view instance

Every view in digster is a instance of the view class and this can be accessed.

```php
$view = digster_view( 'page', [, $data = [] ] );

// or (only if `view` function don't exists.)
$view = view( 'page', [, $data = [] ] );

echo $view;
```

#### Nested views

`digster_view` or `view` will return the view instance so you can use the `nest` method.

```php
echo view( 'user.profile' )
  ->nest( 'picture', 'user.profile.picture', [
    'url' => 'http://site.com/user/1/profile.png'
  ] );
```

```jinja
{# views/user/profile.twig #}
{{ picture }}
```

```jinja
{# views/user/profile/picture.twig #}
<img src="{{ url }}" alt="Profile picture" />
```

You can do the same with `digster_render` and `digster_fetch`

```php
digster_render( 'user.profile', [
  'picture' => digster_fetch( 'user.profile.picture', [
      'url' => 'http://site.com/user/1/profile.png'
  ] )
] );
```

#### Register composer

With Digster you can register composer with wildcard template or a specified template.

This example is for `post` object, but Digster already have this global variable loaded.

```php
// '*', 'page' or 'page.twig'
digster_composer( 'page', function ( $vars ) {
  $vars['post'] = is_numeric( $vars['post'] ) ?  get_page( $vars['post'] ) : $vars['post'];
  return $vars;
});

// Only need to get the post ID
digster_render( 'page', [
  'post' => get_the_ID()
] );
```

You can also create a composer class that you can add with `digster_composer`. The only method that is required on a composer class is `compose` that takes a view argument.

```php
class Profile_Composer {

  public function compose( $view ) {
    $view->with( 'job', 'developer' );
  }

}

digster_composer( 'user.profile', 'Profile_Composer' );
```

#### Register custom filters

Since `1.7.1`

```php
add_filter( 'digster/filters', function ( $filters ) {
  return array_merge( $filters, [
    'hello' => function ( $text ) {
      return 'hello';
    }
  ] )
} );
```

#### Register custom functions

Since `1.7.1`

```php
add_filter( 'digster/functions', function ( $functions ) {
  return array_merge( $functions, [
    'uniqid' => 'uniqid'
  ] )
} );
```

#### Register custom globals

Since `1.7.1`

```php
add_filter( 'digster/globals', function ( $globals ) {
  return array_merge( $globals, [
    'num' => 1
  ] )
} );
```

#### Register extension

Register [Twig extension](http://twig.sensiolabs.org/doc/advanced.html) classes with Digster.

```php
digster_register_extensions( new My_First_Twig_Extension() );

// or

digster_register_extensions( [
	new My_First_Twig_Extension(),
	new My_Second_Twig_Extension()
] );
```

#### Render a view

Render a view

```php
digster_render( 'page' [, $data = []] );
```

#### Share data between views

You can either use `digster_composer` with `*` (wildcard) to share data between views or use `digster_share`. All shared that can be overwrite.

```php
digster_share( 'site_name', 'Example' );
```

## Twig filters

#### apply_filters

Apply filters to Twig output.

```jinja
{{ '@frozzare' | apply_filters('twitter_link') }}
```

#### Excerpt

Get the post summary

```jinja
{{ post.post_content | excerpt }}
```

#### Shortcodes

Run WordPress shortcodes on the text

```jinja
{{ post.post_content | shortcodes | raw }}
```
#### wpautop

Append p tags to the text

```jinja
{{ post.post_content | wpautop | raw }}
```

## Twig functions

Since `1.7.1` you can call `esc_html__`, `esc_html_e`, `esc_attr__`, `esc_attr_e`, `esc_js`, `esc_textarea`, `esc_url` and `esc_url_raw` with the same arguments as you should use in WordPress.

#### Call `__`

The same argument as WordPress's [__](https://codex.wordpress.org/Function_Reference/_2).

Digster has full support for Twig i18n, [read more about it](#twig-i18n).

```jinja
{{ __( 'Hello World!', 'your_textdomain' ) }}
```

#### Call `_n`

The same argument as WordPress's [_n](https://codex.wordpress.org/Function_Reference/_n).

Digster has full support for Twig i18n, [read more about it](#twig-i18n).

```jinja
{{ _n('%s star', '%s stars', rating, 'your_textdomain') | format(rating) }}
```

#### Call action

You can send more arguments to `do action`

```jinja
{% do action('my_action') %}
```

#### Call apply_filters

Takes the same arguments as `apply_filters`

```jinja
{{ apply_filters() }}
```

#### Call body_class

```jinja
<body {{ body_class() }}>
```

#### Call language_attributes

```jinja
<html {{ language_attributes() }}>
```

#### Call random function

You can send in more arguments to `fn`

```jinja
<body {{ fn('my_function', 'a', 'b') }}>
```

#### Call wp_footer

```jinja
{{ wp_footer() }}
```

#### Call wp_head

```jinja
{{ wp_head() }}
```

#### Call wp_title

Takes the same arguments as `wp_title`

```jinja
{{ wp_title() }}
```

## Twig globals

#### post

`post` is global when `get_the_ID()` returns a id.

```jinja
<h1>{{ post.post_title }}</h1>
```

## Twig i18n

Digster has full support for Twig [i18n](http://twig.sensiolabs.org/doc/extensions/i18n.html) extensions. You don't have to do anything to enable it, just use it! It will load the theme text domain automatic. Don't forget to add it to your `style.css`.

Using [Poedit](https://poedit.net)? You should look at [Twig Gettext Extractor](https://github.com/umpirsky/Twig-Gettext-Extractor)! Digster will install Twig Gettext Extractor so you don't have to do it!

```jinja
{% trans "Hello World!" %}

{% trans string_var %}

{% trans %}
    Hello World!
{% endtrans %}
```

## Cache

Look at [Twig cache extension](https://github.com/asm89/twig-cache-extension) (Digster installs the package so you don't have to install it). Digster has a build in cache provider that uses the [WordPress Object cache](http://codex.wordpress.org/Class_Reference/WP_Object_Cache).

```php
use Frozzare\Digster\Cache\WordPress_Cache_Adapter;
use Asm89\Twig\CacheExtension\CacheStrategy\LifetimeCacheStrategy;
use Asm89\Twig\CacheExtension\Extension as CacheExtension;

$cache_provider  = new WordPress_Cache_Adapter();
$cache_strategy  = new LifetimeCacheStrategy($cache_provider);
$cache_extension = new CacheExtension($cache_strategy);

digster_register_extensions( $cache_extension );
```

## Coding style

You can check if your contribution passes the styleguide by installing [PHP CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) and running the following in your project directory:

```
vendor/bin/phpcs -s --extensions=php --standard=phpcs.xml src/
```

## License

MIT © [Fredrik Forsmo](https://github.com/frozzare)
