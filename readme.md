![#bFrame](https://i.imgur.com/LUheEDD.png)
# What is this?
This is a really basic base framework with Twig I've created so I can kick start projects a bit quicker.
It's easily modifiable to how/what ever you need to do with it.
This is powering my site, [tyler.ac](https://tyler.ac).

## Installation
A quick, pretty easy guide:
1. Clone/download and navigate to that directory
2. Run `composer install` and `npm install` in your terminal
3. In `/App/` copy `Config.sample.php` to `Config.php` and fill with your env details
4. ???
5. You should be up and running

-----
## Routing
It does what it says, really. Examples and the place where your routes go can be found in `/App/Routes/`  
```php
$router->add(['','home'], ['controller' => 'Home', 'action' => 'index']);
```
The code above will allow someone to access `localhost` and `localhost/home`, the controller is `/App/Controllers/Home.php` and the method in that class is `indexAction` which would in theory would be used to display your index/home landing page with Twig  

#### Closure routes are possible too!
If you want just a simple route and you're not wanting to create a controller or method for it, just look at the example below
```php
$router->add('account/logout', function(){
    session_destroy();
    header("Location: /", 302);
    die();
});
```

## Views
Views can be found in `App/Views`, the home for all the websites views. This uses Twig templating engine, you can read more [here](https://twig.symfony.com/).  
You can find the base for all the views templates in `App/Views/base.php` where you can see an example within that file.

#### Rendering a template
Rendering a template with or without variables is quite simple with the code below
```php
$blogPosts = Database::getAll("SELECT id FROM blog ORDER BY id DESC");
View::renderTemplate('Home/index.php', [
  'blogPosts' => $blogPosts
]);
```
and within this template, `Home/index.php` we would just use the code below to display data from $blogPosts
```twig
{% for post in blogPosts %}
  Post ID: {{ post.id }}
{% endfor %}
```

-----

## Support
I'll update this repo whenever I change or fix something but other than that it'll be slim.

## Contributing
Please feel free to add or change anything, I know there's aspects what are total crap or need fixing and I will get around to doing so at some point.
Open a issue or submit a pull request.