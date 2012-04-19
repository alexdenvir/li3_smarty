# [Smarty](http://www.smarty.net) PHP plugin for [Lithium PHP](http://lithify.me)
Adds Smarty Templating Engine support to Lithium PHP Framework.

I can't claim to be a fan of smarty, or php templating languages in general, but Smarty was a requirement from my employer.

So, alas, here is a plugin to run lithium thru smarty properly.

## Installation
1. Clone/Download the plugin into your app's ``libraries`` directory.
2. Tell your app to load the plugin by adding the following to your app's ``config/bootstrap/libraries.php``:

        Libraries::add('li3_smarty');

## Usage
The plugin was written to mimic core Li3 variable assignment - therefore you can pass variables to your views like normal

### Some Example code

__PagesController.php__

~~~ php
<?php 
	...
	class PagesController extends \lithium\action\Controller {

		public function home(){
			$var = "test variable!";
			$this->set(compact('var'));
		}
?>
~~~

Then in your view:

__home.html.tpl__

~~~ html
I want to display my {$var}
~~~

which will render "I want to display my `test variable!`"

> You may have noticed that the view ended in .tpl, this is required for the plugin to parse the template as a smarty template.

## Inheritance 
Arguably one of the single most useful things smarty offers is its template inheritance.

This plugin treats views as layouts, so your view will need to extend the proper layout in order for it to render properly.

> Think of this as `$this->content()` in reverse, you tell your view which layout to use rather than the layout where to include your view.

__default.html.tpl__

> notice: layouts are also `.tpl` files

~~~ html
<html>
	<head>...</head>
	<body>
		{block name="content"}{/block}
	</body>
</html>
~~~

__home.html.tpl__

~~~ html
{extends file="default.html.tpl"}
{block name="content"}
	<p>This is the view content that needs to be passed to <code>default.html.tpl</code></p>
	<p>Also ... I want to display my {$var}</p>
{/block}
~~~

Now `http://localhost/home` would render as

~~~ html
<html>
	<head>...</head>
	<body>
		<p>This is the view content that needs to be passed to <code>default.html.tpl</code></p>
		<p>Also ... I want to display my `test variable!`</p>
	</body>
</html>
~~~

## Extending Smarty
If you want to add extraordinarily nifty functionality to smarty then you would do so by writing a smarty plugin.

If you choose to write some of these you can place them in one of the following locations and they will be automatically included for you and ready for use in your layouts/views:

1. `extensions/plugins` - from within your lithium app
2. `li3_smarty/plugins` - this is where I'm adding plugins I feel should be distributed with this lithium plugin.

I wont get into how or why you'd write these so check out the [smarty plugin docs](http://www.smarty.net/docs/en/plugins.tpl) if you'd like to learn more about his feature (they're like helpers written for smarty).

## Lithium Helpers
This ... was tricky.

To lose lithium php helpers is the same as losing both feet and 4 fingers, including both thumbs ... I __HAD__ to come up with a way to expose helpers to smarty templates.

I've written a smarty plugin, called `helper` which exposes all lithium helper methods to the smarty template.

### Helper Usage

__Lithium Link Helper__

~~~ php
<?= $this->html->link('My Github', 'http://www.github.com/joseym', array('class' => 'external')); ?>
~~~

__Smarty Link Helper__

~~~ html
	...
	<body>
		{helper init="html:link" title="My Github" href="http://www.github.com/joseym" options=['class' => 'external']}
	</body>
	...
~~~

Both of the above would return `<a href="http://www.github.com/joseym" class="external">My Github</a>`

### Helper Requirements

I'm going to break the smarty helper method down for you

1. __helper__ : `required` This calls the helper smarty plugin
2. __init__ : `required` This is the class:method you want to use; in my example I'm using the `html` class with the `link` helper - `html:link`
3. __title__ : _optional_ This, and any other params are optional and depend on the lithium helper you're using
4. __href__ : _optional_ same as `title`, it's optional for the smarty helper method but a requirement for the lithium html link helper.

> Note: Helper params can be called anything, we could have just as easily called `title` and `href` `name` and `url`. The only key names that are `required` to be as show above are `init` and `options`

5. __options__ : _optional_ An Associative array of optional parameters as used by lithium

> If you are passing in an array of options the key __must__ be called `options` for it to be used correctly by the smarty plugin

That should do it, I've tested with a few different core helpers and it works as expected, please log an issue if a helper fails to work properly with this method and I'll attempt to add support as soon as possible.

## Collaborate
As always, I welcome your collaboration to make things "even more betterer", so fork and contribute if you feel the need.

### New to Smarty?
Documentation available at http://www.smarty.net/docs/en/