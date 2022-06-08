{{-- {# {{ asset_add("scripts.js", "ui::js/tree/jquery-sortable.js") }}
{{ asset_add("scripts.js", "ui::js/tree/tree.js") }}

{% import "ui::tree/macro" as macro %}

{% block content %}

    <div class="container-fluid">

        {% if not tree.items.empty() %}
            <ul class="tree tree--sortable sortable">
                {{ macro.tree(tree.items.root(), tree) }}
            </ul>
        {% else %}
            <div class="card">
                <div class="card-block card-body">
                    {{ trans(tree.options.get('no_results_message', 'ui::messages.no_results')) }}
                </div>
            </div>
        {% endif %}

    </div>

{% endblock %} #} --}}
tree.blade.php
