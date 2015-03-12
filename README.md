# Digster

> [WIP] Twig templates for WordPress

Digster it's a WordPress plugin that allows you to render Twig views with a
few Twig [filters](#twig-filters), [functions](#twig-functions) and [globals](#twig-globals).

It's easy to register your own [extensions](#register-extension) or [preprocesses](#register-preprocess).

[![Build Status](https://travis-ci.org/frozzare/digster.svg?branch=master)](https://travis-ci.org/frozzare/digster)

## Example

Example of `page.php`

`page.php`
```php
// 'page' or 'page.twig'
digster_render('page');
```

`page.twig`
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

All [Twig environment options](http://twig.sensiolabs.org/doc/api.html#environment-options) is prefixed with `twig.`.

```php
add_filter('digster/config', function ($config) {
  $config['twig.debug'] = true;
  return $config;
});
```

## API functions

##### Fetch view

Fetch the view in to a string.

```php
$view = digster_fetch('page' [, $data]);

// or

$view = \Digster\View::fetch('page' [, $data]);
```

#### Register composer

With Digster you can register composer with any template or a specified template.

```php
// 'any', 'page' or 'page.twig'
digster_composer('page', function ($vars) {
  $vars['post'] = is_numeric($vars['post']) ?  get_page($vars['post'] ) : $vars['post'];
  return $vars;
});

// or
\Digster\View::composer('page', function ($vars) {
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
digster_register_extension(new MyTwigExtension());

// or

\Digster\View::registerExtension(new MyTwigExtension());
```

#### Render a view

Render the view

```php
digster_render('page' [, $data]);

// or

\Digster\View::render('page' [, $data]);
```

## Twig filters

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

```html
{% do action('my_action') %}
```

#### Call wp head

```html
{{ wp_head }}
```

#### Call wp footer

```html
{{ wp_footer }}
```

## Twig globals

#### post

`post` is global when `get_the_ID()` returns a id.

```html
<h1>{{ post.post_title }}</h1>
```

#### body_class

`body_class` will print the body classes.

```html
<body class="{{ body_class }}">
```

## Coding Style

Follow [PSR-2](http://www.php-fig.org/psr/psr-2/) with the following additional rules:

- Functions that should be used in a WordPress theme should not be camelCase, instead use underscores.
- Use short array syntax.

Follow [PSR-4](http://www.php-fig.org/psr/psr-4/) for autoloading.

You can check if your code passes the styleguide by installing [PHP CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) and running the following in your project directory:

```
phpcs --standard=phpcs.xml --extensions=php -n -s .
```
