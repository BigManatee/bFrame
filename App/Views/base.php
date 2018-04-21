<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>{% block title %}{% endblock %}</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" href="icon.png">
        <link rel="icon" type="image/x-icon" href="{{ app.baseUrl }}/favicon.png" />
        <link rel="icon" type="image/png" href="{{ app.baseUrl }}/favicon.png" sizes="32x32" />
        <link rel="icon" type="image/png" href="{{ app.baseUrl }}/favicon.png" sizes="16x16" />
        <meta name="theme-color" content="#333" />
        
        <link rel="stylesheet" href="{{ app.baseUrl }}/static/css/main.css">

        {% block metadata %}{% endblock %}
    </head>
    <body>
        <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

        {% block body %}{% endblock %}
        
        {% block footer %}{% endblock %}
    </body>
</html>
