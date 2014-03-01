<?php
Router::connect('/factures', array('controller' => 'factures', 'action' => 'index', 'plugin' => 'facture_manager'));
Router::connect('/factures/:action/*', array('controller' => 'factures', 'action' => '[a-z]+', 'plugin' => 'facture_manager'));
Router::connect('/proformas', array('controller' => 'proformas', 'action' => 'index', 'plugin' => 'facture_manager'));
Router::connect('/proformas/:action/*', array('controller' => 'proformas', 'action' => '[a-z]+', 'plugin' => 'facture_manager'));
Router::connect('/proforma_statuts', array('controller' => 'proforma_statuts', 'action' => 'index', 'plugin' => 'facture_manager'));
Router::connect('/proforma_statuts/:action/*', array('controller' => 'proforma_statuts', 'action' => '[a-z]+', 'plugin' => 'facture_manager'));
Router::connect('/facture_articles', array('controller' => 'article_familles', 'action' => 'index', 'plugin' => 'facture_manager'));
Router::connect('/facture_articles/:action/*', array('controller' => 'article_familles', 'action' => '[a-z]+', 'plugin' => 'facture_manager'));
Router::connect('/paiements', array('controller' => 'paiements', 'action' => 'index', 'plugin' => 'facture_manager'));
Router::connect('/paiements/:action/*', array('controller' => 'paiements', 'action' => '[a-z]+', 'plugin' => 'facture_manager'));
Router::connect('/paiement_modalites', array('controller' => 'paiement_modalites', 'action' => 'index', 'plugin' => 'facture_manager'));
Router::connect('/paiement_modalites/:action/*', array('controller' => 'paiement_modalites', 'action' => '[a-z]+', 'plugin' => 'facture_manager'));
Router::connect('/paiement_types', array('controller' => 'paiement_types', 'action' => 'index', 'plugin' => 'facture_manager'));
Router::connect('/paiement_types/:action/*', array('controller' => 'paiement_types', 'action' => '[a-z]+', 'plugin' => 'facture_manager'));
Router::connect('/statuts', array('controller' => 'statuts', 'action' => 'index', 'plugin' => 'facture_manager'));
Router::connect('/statuts/:action/*', array('controller' => 'statuts', 'action' => '[a-z]+', 'plugin' => 'facture_manager'));
Router::connect('/taxes', array('controller' => 'taxes', 'action' => 'index', 'plugin' => 'facture_manager'));
Router::connect('/taxes/:action/*', array('controller' => 'taxes', 'action' => '[a-z]+', 'plugin' => 'facture_manager'));