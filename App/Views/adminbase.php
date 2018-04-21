<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="robots" content="noindex">
        <meta name="theme-color" content="#000" />
        <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width" />

        <title>{% block title %}{% endblock %}</title>

        <link rel="stylesheet" type="text/css" href="{{ baseUrl }}/static/css/font-awesome.min.css" />
        <link rel="stylesheet" type="text/css" href="{{ baseUrl }}/static/css/app.css" />
        <link rel="stylesheet" type="text/css" href="{{ baseUrl }}/static/css/cookieconsent.min.css" />
        <link rel="icon" type="image/x-icon" href="{{ baseUrl }}/static/favicon.png" />
        <link rel="icon" type="image/png" href="{{ baseUrl }}/static/favicon.png" sizes="32x32" />
        <link rel="icon" type="image/png" href="{{ baseUrl }}/static/favicon.png" sizes="16x16" />
    </head>

    <body>
        <header>
            <nav class="gtm__navigation__desktop l__wrapper l__row l__row--h-stretch l__hide--on-small-laptop space--20-0">
                <ul class="list__links list__links--row list__links--no-decor list__links--nav">
                    <li><a href="/MI3" class="link--no-decor text--logo">MI3</a></li>
                </ul>
                <div class="l__row">
                    <div class="nav-dropdown">
                    </div>

                    <a href="/" class="text--body b__nudge--right">Main Site</a>
                    {% if app.request.session.adm_login is defined %}
                        <a href="/MI3/control-room" class="text--body {% if ('/MI3/control-room' in siteUrl) %}link--no-decor{% endif %} b__nudge--right">Control Room</a>
                    {% endif %}
                </div>
            </nav>
            <!--  Header / Navigation Mobile-->
            <nav class="gtm__navigation__mobile l__wrapper l__hide--above-small-laptop space--20-0">
                <ul class="list__links list__links--row list__links--nav l__row--h-stretch">
                    <li><a href="/MI3" class="link--no-decor text--logo">MI3</a></li>
                    {#<li><a class="btn btn--pink b__nudge--right-extra-large" href="/don">Donner</a></li>#}
                </ul>
                <div class="nav-mobile">
                    <input type="checkbox" id="nav-menu">
                    <label for="nav-menu">Navigation</label>
                    <div class="nav-mobile--menu">
                        <ul>
                            <li>
                                <a href="/">Main Site</a>
                            </li>
                            <li>
                                <a href="/MI3/control-room">Control Room</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        {% block body %}{% endblock %}
        
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript" src="{{ baseUrl }}/static/js/cookieconsent.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/stackblur-canvas/1.4.1/stackblur.min.js"></script>
        <script type="text/javascript" src="{{ baseUrl }}/static/js/kernel.js"></script>

        {% block footer %}{% endblock %}
    </body>
</html>