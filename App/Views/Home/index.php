{% extends "base.php" %}
{% block title %}Title{% endblock %}
{% block metadata %}
<meta name="title" content="Title">
<meta name="description" content="Description" />

<meta property="og:url" content="{{ app.siteUrl }}" />
<meta property="og:title" content="Title" />
<meta property="og:description" content="Description" />
<meta property="og:image" content="img" />
<meta property="og:image:width" content="900" />
<meta property="og:image:height" content="600" />

<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="Title" />
<meta name="twitter:description" content="Description" />
<meta name="twitter:image:src" content="img" />
{% endblock %}

{% block body %}
this is within the <b>{&percnt; block body &percnt;}{&percnt; endblock &percnt;}</b> tag in <b>/App/Views/Home/index.php</b>
{% endblock %}