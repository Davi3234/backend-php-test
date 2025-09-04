<?php
return [
    'POST' => [
        '/pessoas' => [
            'controller' => \Controller\PessoaController::class,
            'action' => 'criarPessoa'
        ]
    ],
    'GET' => [
        '/pessoas' => [
            'controller' => \Controller\PessoaController::class,
            'action' => 'listarPessoas'
        ],
        '/pessoas/{id}' => [
            'controller' => \Controller\PessoaController::class,
            'action' => 'buscarPessoa'
        ]
    ],
    'PUT' => [
        '/pessoas/{id}' => [
            'controller' => \Controller\PessoaController::class,
            'action' => 'editarPessoa'
        ]
    ],
    'DELETE' => [
        '/pessoas/{id}' => [
            'controller' => \Controller\PessoaController::class,
            'action' => 'excluirPessoa'
        ]
    ]
];
