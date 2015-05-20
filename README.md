# Digster

> Twig templates for WordPress

Digster it's a WordPress plugin that allows you to render Twig views with a
few Twig [filters](#twig-filters), [functions](#twig-functions) and [globals](#twig-globals).

It's easy to register your own [extensions](#register-extension) or [composers](#register-composer).

[![Build Status](https://travis-ci.org/frozzare/digster.svg?branch=master)](https://travis-ci.org/frozzare/digster)

## Example

Example of `page.php`

```php
// 'page' or 'page.twig'
digster_render('page');
```

Example of `page.twig`
```html
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

Digster has a few WordPress filters, one is the config filter.

```php
add_filter('digster/config', function ($config) {
  return $config;
});
```

#### Locations

A array with the locations of the views. By default
the `get_templates_directory() . '/views'` is registered.

```php
add_filter('digster/config', function ($config) {
  $config['locations'] = 'path/to/locations';
  return $config;
});
```

#### Twig environment options

Read about the options on the [Twig site](http://twig.sensiolabs.org/doc/api.html#environment-options)

`auto_reload` example
```php
add_filter('digster/config', function ($config) {
  $config['auto_reload'] = true;
  return $config;
});
```

## API functions

##### Fetch view

Fetch the view in to a string.

```php
$view = digster_fetch('page' [, $data]);
```

#### Register composer

With Digster you can register composer with any template or a specified template.

This example is for `post` object, but Digster already have this global variable loaded.

```php
// 'any', 'page' or 'page.twig'
digster_composer('page', function ($vars) {
  $vars['post'] = is_numeric($vars['post']) ?  get_page($vars['post'] ) : $vars['post'];
  return $vars;
});

// Only need to get the post ID
digster_render('page', [
  'post' => get_the_ID()
])
```

#### Register extension

Register Twig extension classes with Digster.

```php
digster_register_extensions(new My_First_Twig_Extension());

// or

digster_register_extensions([
	new My_First_Twig_Extension(),
	new My_Second_Twig_Extension()
]);
```

#### Render a view

Render the view

```php
digster_render('page' [, $data]);
```

## Twig filters

#### apply_filters

Apply filters to Twig output.

```html
{{ '@frozzare' | apply_filters('twitter_link') }}
```

#### Excerpt

Get the post summary

```html
{{ post.post_content | excerpt }}
```

#### Shortcodes

Run WordPress shortcodes on the text

```html
{{ post.post_content | shortcodes | raw }}
```
#### wpautop

Append p tags to the text

```html
{{ post.post_content | wpautop | raw }}
```

## Twig functions

#### Call action

You can send more arguments to `do action`.

```html
{% do action('my_action') %}
```

#### Call apply_filters

Takes the same arguments as `apply_filters`.

```html
{{ apply_filters() }}
```

#### Call body_class

```html
<body {{ body_class() }}>
```

#### Call language_attributes

```html
<html {{ language_attributes() }}>
```

#### Call random function

You can send in more arguments to `fn`.

```html
<body {{ fn('my_function', 'a', 'b') }}>
```

#### Call wp_footer

```html
{{ wp_footer() }}
```

#### Call wp_head

```html
{{ wp_head() }}
```

#### Call wp_title

Takes the same arguments as `wp_title`.

```html
{{ wp_title() }}
```

## Twig globals

#### post

`post` is global when `get_the_ID()` returns a id.

```html
<h1>{{ post.post_title }}</h1>
```

## Cache

Look at [Twig cache extension](https://github.com/asm89/twig-cache-extension) (Digster installs the package so you don't have to install it). Digster has a build in cache provider that uses the [WordPress Object cache](http://codex.wordpress.org/Class_Reference/WP_Object_Cache).

```php
use Digster\Cache\WordPress_Cache_Adapter;
use Asm89\Twig\CacheExtension\CacheStrategy\LifetimeCacheStrategy;
use Asm89\Twig\CacheExtension\Extension as CacheExtension;

$cache_provider  = new WordPress_Cache_Adapter();
$cache_strategy  = new LifetimeCacheStrategy($cache_provider);
$cache_extension = new CacheExtension($cache_strategy);

digster_register_extensions($cache_extension);
```

## Coding style

Digster has a `phpcs.rulset.xml` so you can check the source code coding style.

```
$ vendor/bin/phpcs -s --extensions=php --standard=phpcs.ruleset.xml src/
```

# License

MIT © [Fredrik Forsmo](https://github.com/frozzare)
