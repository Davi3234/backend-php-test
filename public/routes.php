<?php
return [
    'POST' => [
        '/pessoas' => [
            'controller' => \Controller\PessoaController::class,
            'action' => 'criarPessoa'
        ],
        '/contatos' => [
            'controller' => \Controller\ContatoController::class,
            'action' => 'criarContato'
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
        ],
        '/contatos' => [
            'controller' => \Controller\ContatoController::class,
            'action' => 'listarContatos'
        ],
        '/contatos/{id}' => [
            'controller' => \Controller\ContatoController::class,
            'action' => 'buscarContato'
        ]
    ],
    'PUT' => [
        '/pessoas/{id}' => [
            'controller' => \Controller\PessoaController::class,
            'action' => 'editarPessoa'
        ],
        '/contatos/{id}' => [
            'controller' => \Controller\ContatoController::class,
            'action' => 'editarContato'
        ]
    ],
    'DELETE' => [
        '/pessoas/{id}' => [
            'controller' => \Controller\PessoaController::class,
            'action' => 'excluirPessoa'
        ],
        '/contatos/{id}' => [
            'controller' => \Controller\ContatoController::class,
            'action' => 'excluirContato'
        ]
    ]
];
