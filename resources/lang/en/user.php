<?php

return [
    'pages' => [
        'auth' => [
            'buttons' => [
                'sign_in' => 'Sign In',
                'sign_up' => 'Sign Up',
                'reset'   => 'Reset Password',
                'forgot'  => 'Send Reset Email',
            ],
            'messages' => [
                'remember_me'     => 'Remember Me',
                'forgot_password' => 'Forget Password',
                'email'           => 'Email',
                'password'        => 'Password',
            ],
        ],
        'tasks' => [
            'buttons' => [
                'back' => '< Go Back',
                'new' => 'Create New Task',
                'create' => 'Create This Task',
                'save' => 'Save This Task',
                'delete' => 'Delete This Task',
                'search' => 'Search',
                'sort' => 'Sort',
            ],
            'top' => [
                'index' => 'You have these upcoming tasks',
                'index_empty' => 'You don\'t have any tasks',
                'create' => 'Create a new task',
                'edit' => 'Edit this task',
            ],
            'field_warning' => [
                'name' => 'Please Enter a Name',
                'duedate' => 'Please Enter a Due Date',
            ],
            'field_placeholder' => [
                'filter' => 'filter',
                'name' => 'enter a name',
                'description' => 'description goes here',
            ],
        ]
    ],
];
