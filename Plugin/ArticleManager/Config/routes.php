<?php
Router::connect('/depots', array('controller' => 'depots', 'action' => 'index', 'plugin' => 'article_manager'));
Router::connect('/depots/:action/*', array('controller' => 'depots', 'action' => '[a-z]+', 'plugin' => 'article_manager'));
Router::connect('/stocks', array('controller' => 'mouvements', 'action' => 'index', 'plugin' => 'article_manager'));
Router::connect('/stocks/:action/*', array('controller' => 'mouvements', 'action' => '[a-z]+', 'plugin' => 'article_manager'));
Router::connect('/mouvement_types', array('controller' => 'mouvement_types', 'action' => 'index', 'plugin' => 'article_manager'));
Router::connect('/mouvement_types/:action/*', array('controller' => 'mouvement_types', 'action' => '[a-z]+', 'plugin' => 'article_manager'));
Router::connect('/articles', array('controller' => 'articles', 'action' => 'index', 'plugin' => 'article_manager'));
Router::connect('/articles/:action/*', array('controller' => 'articles', 'action' => '[a-z]+', 'plugin' => 'article_manager'));
Router::connect('/famille_articles', array('controller' => 'article_familles', 'action' => 'index', 'plugin' => 'article_manager'));
Router::connect('/famille_articles/:action/*', array('controller' => 'article_familles', 'action' => '[a-z]+', 'plugin' => 'article_manager'));
Router::connect('/unites', array('controller' => 'unites', 'action' => 'index', 'plugin' => 'article_manager'));
Router::connect('/unites/:action/*', array('controller' => 'unites', 'action' => '[a-z]+', 'plugin' => 'article_manager'));