<?php

return [
    'post_insert' => [
        'api_endpoint' => 'https://sq1-api-test.herokuapp.com/posts',
        'is_published' => 1,
        'admin_id' => '40d2b815-3ae8-4559-868b-7ae77942804f'
    ],

    'elsatic_search' => [
        'es_url' => 'localhost:9200',
        'default_index' => 'posts',
        'index_data' => '{
            "mappings": {
              "properties": { 
                "id":  { "type": "text", "index" : false }, 
                "title":   { "type": "text"  },
                "body":   { "type": "text"  },
                "user_id": { "type": "keyword", "index": true },
                "user_name" : { "type" : "text" },
                "is_published":    { "type": "integer" },
                "created_at": { "type": "date" , "format": "yyyy-MM-dd HH:mm:ss" },
                "updated_at": { "type": "date", "format": "yyyy-MM-dd HH:mm:ss" }
              }
            }
          }',
        
    ]
];
