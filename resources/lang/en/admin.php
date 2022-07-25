<?php

return [
    'admin-user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
            'edit_profile' => 'Edit Profile',
            'edit_password' => 'Edit Password',
        ],

        'columns' => [
            'id' => 'ID',
            'last_login_at' => 'Last login',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Password Confirmation',
            'activated' => 'Activated',
            'forbidden' => 'Forbidden',
            'language' => 'Language',

            //Belongs to many relations
            'roles' => 'Roles',

        ],
    ],

    'branch' => [
        'title' => 'Branches',

        'actions' => [
            'index' => 'Branches',
            'create' => 'New Branch',
            'edit' => 'Edit :name',
            'will_be_published' => 'Branch will be published at',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'number' => 'Number',
            'address' => 'Address',
            'bin' => 'Bin',
            'perex' => 'Perex',
            'published_at' => 'Published at',
            'enabled' => 'Enabled',

        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];
