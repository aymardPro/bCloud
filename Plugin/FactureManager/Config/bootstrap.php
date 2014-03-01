<?php

Configure::write('bCloud.Article.Type', array('CENTRALISATEUR', 'DETAIL'));
Configure::write('bCloud.Taxe.Type', array('TAXE SUR ACHAT', 'TAXE SUR VENTE'));

Configure::write('bCloud.Proforma.Statut.WAITING', 5);
Configure::write('bCloud.Proforma.Statut.VALIDE', 6);
Configure::write('bCloud.Proforma.Statut.REJETE', 7);

Configure::write('bCloud.Facture.Statut.ACOMPTABILISER', 10);
Configure::write('bCloud.Facture.Statut.REGLE', 11);
