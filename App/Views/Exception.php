<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Whoops! There was an error.</title>
    <link href="/static/css/exception.css" media="all" rel="stylesheet" />
</head>
<body>
    <div class="Whoops container">
        <div class="stack-container">
            <div class="left-panel cf ">
                <header>
                    <div class="exception">
                        <div class="exc-title">
                            <span class="exc-title-primary">Uncaught Exception</span>
                        </div>

                        <span id="plain-exception"></span>
                        <button id="copy-button" class="clipboard" data-clipboard-text="Uncaught Exception: {{ uncaught_exception }} {{ message }}">COPY</button>

                        <p class="exc-message">{{ uncaught_exception }}</p>
                    </div>
                </header>

                <div class="frames-description">
                    Stack frames:
                </div>

                <div class="frames-container">
                    <div class="frame active" id="frame-line-0">
                        <div class="frame-method-info">
                            <span class="frame-index">1</span>
                            <span class="frame-class">Uncaught Exception</span>
                            <span class="frame-function"></span>
                        </div>
                        <span class="frame-file">
      						{{ file }}<span class="frame-line">{{ file_line }}</span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="details-container cf">
                <div class="frame-code-container ">
                    <div class="frame-code active" id="frame-code-0">
                        <div class="frame-file">
                            <strong>{{ file }}</strong>
                        </div>
                        <pre class="code-block prettyprint linenums:1">
{% for line in code_lines %}
{{ line }}
{% endfor %}
 </pre>

                        <div class="frame-comments">
                        	<div class="frame-comment" id="comment-1-0">
              					<span class="frame-comment-context"></span>
              					{{ message }}
              				</div>
              				<div class="frame-comment" id="comment-2-0">
              					<span class="frame-comment-context">Stack Trace</span>
              					<pre style="overflow-x:scroll">{{ stack }}
              					</pre>
              				</div>
                        </div>
                    </div>
                </div>
                <div class="details">
                    <h2 class="details-heading">Environment &amp; details:</h2>

                    <div class="data-table-container" id="data-tables">
                        <div class="data-table" id="sg-get-data">
                            <label {% if get_data is empty %} class="empty" {% endif %}>GET Data</label>
                            {% if get_data is empty %}
								<span class="empty">empty</span>
							{% endif %}
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <td class="data-table-k">Key</td>
                                        <td class="data-table-v">Value</td>
                                    </tr>
                                </thead>
                                {% for key,val in get_data %}
                                <tr>
                                    <td>{{ key }}</td>
                                    <td>{{ val }}</td>
                                </tr>
                                {% endfor %}
							</table>
                        </div>
                        <div class="data-table" id="sg-post-data">
                            <label {% if post_data is empty %} class="empty" {% endif %}>POST Data</label>
                            {% if post_data is empty %}
								<span class="empty">empty</span>
							{% endif %}
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <td class="data-table-k">Key</td>
                                        <td class="data-table-v">Value</td>
                                    </tr>
                                </thead>
                                {% for key,val in post_data %}
                                <tr>
                                    <td>{{ key }}</td>
                                    <td>{{ val }}</td>
                                </tr>
                                {% endfor %}
							</table>
                        </div>
                        <div class="data-table" id="sg-cookies">
                            <label {% if cookie_data is empty %} class="empty" {% endif %}>Cookies</label>
                            {% if cookie_data is empty %}
								<span class="empty">empty</span>
							{% endif %}
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <td class="data-table-k">Key</td>
                                        <td class="data-table-v">Value</td>
                                    </tr>
                                </thead>
                                {% for key,val in cookie_data %}
                                <tr>
                                    <td>{{ key }}</td>
                                    <td>{{ val }}</td>
                                </tr>
                                {% endfor %}
							</table>
                        </div>
                        <div class="data-table" id="sg-session">
                            <label {% if session_data is empty %} class="empty" {% endif %}>Session</label>
                            {% if session_data is empty %}
								<span class="empty">empty</span>
							{% endif %}
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <td class="data-table-k">Key</td>
                                        <td class="data-table-v">Value</td>
                                    </tr>
                                </thead>
                                {% for key,val in session_data %}
                                <tr>
                                    <td>{{ key }}</td>
                                    {% if val is iterable %}
                                        {% for a,c in val %}
                                            {{ a }} = {{ c }}<br>
                                        {% endfor %}
                                    {% else %}
                                        <td>{{ val }}</td>
                                    {% endif %}
                                </tr>
                                {% endfor %}
							</table>
                        </div>
                        <div class="data-table" id="sg-serverrequest-data">
                            <label {% if server_data is empty %} class="empty" {% endif %}>Server/Request Data</label>
                            {% if server_data is empty %}
								<span class="empty">empty</span>
							{% endif %}
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <td class="data-table-k">Key</td>
                                        <td class="data-table-v">Value</td>
                                    </tr>
                                </thead>
                                {% for key,val in server_data %}
                                <tr>
                                    <td>{{ key }}</td>
                                    <td>{{ val }}</td>
                                </tr>
                                {% endfor %}
							</table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/zepto/1.2.0/zepto.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.7.1/clipboard.min.js"></script>
    <script src="/static/js/exception.js"></script>
</body>
</html>