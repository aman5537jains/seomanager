<?php 

return
    [
    "models"=>[
        "Institute"=>"\\App\\User",
        "Country"=>"\\App\\Model\\Country"
    ]   ,
    "except_routes"=>[
        "admin",
        "api",
        'filemanager',
        'file-manager',
        'seo-manager',
        "_debugbar",
        "docs"
    ],
    "subdomain"=>[
        "www",
        // "*"=>["route"=>"{prefix_url}.jiunge.com",]
    ]
];