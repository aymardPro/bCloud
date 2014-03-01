<?php
Router::connect('/clients', array('controller' => 'clients', 'action' => 'index', 'plugin' => 'relation_manager'));
Router::connect('/clients/:action/*', array('controller' => 'clients', 'action' => '[a-z]+', 'plugin' => 'relation_manager'));
Router::connect('/secteurs', array('controller' => 'client_activities', 'action' => 'index', 'plugin' => 'relation_manager'));
Router::connect('/secteurs/:action/*', array('controller' => 'client_activities', 'action' => '[a-z]+', 'plugin' => 'relation_manager'));