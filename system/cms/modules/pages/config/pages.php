<?php

// and now the content for the pages
$config['pages:default_page_content'] = array(
        /* The home page data. */
        'home' => array(
            'created_at' => date('Y-m-d H:i:s'),
            'body' => '<p>Welcome to our homepage. We have not quite finished setting up our website yet, but please add us to your bookmarks and come back soon.</p>',
            'slug'          => 'home',
            'title'         => 'Home',
            'status'        => 'live',
            'created_at'    => date('Y-m-d H:i:s'),
            'is_home'       => true,
            'created_by' => 1
        ),
        /* The contact page data. */
        'contact' => array(
            'created_at' => date('Y-m-d H:i:s'),
            'body' => '<p>To contact us please fill out the form below.</p>
                {{ contact:form name="text|required" email="text|required|valid_email" subject="dropdown|Support|Sales|Feedback|Other" message="textarea" attachment="file|zip" }}
                    <div><label for="name">Name:</label>{{ name }}</div>
                    <div><label for="email">Email:</label>{{ email }}</div>
                    <div><label for="subject">Subject:</label>{{ subject }}</div>
                    <div><label for="message">Message:</label>{{ message }}</div>
                    <div><label for="attachment">Attach  a zip file:</label>{{ attachment }}</div>
                {{ /contact:form }}',
            'created_by' => 1,
            'slug'          => 'contact',
            'title'         => 'Contact',
            'status'        => 'live',
            'created_at'    => date('Y-m-d H:i:s'),
            'is_home'       => false,
        ),
        /* The search page data. */
        'search' => array(
            'created_at' => date('Y-m-d H:i:s'),
            'body' => "{{ search:form class=\"search-form\" }} \n		<input name=\"q\" placeholder=\"Search terms...\" />\n	{{ /search:form }}",
            'created_by' => 1
        ),
        /* The search results page data. */
        'search-results' => array(
            'created_at' => date('Y-m-d H:i:s'),
            'body' => "{{ search:form class=\"search-form\" }} \n		<input name=\"q\" placeholder=\"Search terms...\" />\n	{{ /search:form }}\n\n{{ search:results }}\n\n	{{ total }} results for \"{{ query }}\".\n\n	<hr />\n\n	{{ entries }}\n\n		<article>\n			<h4>{{ singular }}: <a href=\"{{ url }}\">{{ title }}</a></h4>\n			<p>{{ description }}</p>\n		</article>\n\n	{{ /entries }}\n\n        {{ pagination }}\n\n{{ /search:results }}",
            'created_by' => 1
        ),
        'fourohfour' => array(
            'created_at' => date('Y-m-d H:i:s'),
            'body' => '<p>We cannot find the page you are looking for, please click <a title="Home" href="{{ pages:url id=\'1\' }}">here</a> to go to the homepage.</p>',
            'created_by' => 1,
            'slug'          => '404',
            'title'         => 'Page missing',
            'status'        => 'live',
            'created_at'    => date('Y-m-d H:i:s'),
            'is_home'       => 0,
        )
);
