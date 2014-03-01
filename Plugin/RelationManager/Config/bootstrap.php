<?php


Configure::write('RelationManager.datatype', array (
    69 => 'ADRESSE DE FACTURATION',
    70 => 'SITUATION GEOGRAPHIQUE',
    71 => 'TELEPHONE',
    72 => 'CELLULAIRE',
    73 => 'FAX',
    74 => 'E-MAIL'
    )
);

Configure::write('RelationManager.Genre', array (
    'HOMME',
    'FEMME'
    )
);

Configure::write('RelationManager.FormeJuridique', array (
    'SA' => array(
        '00' => 'Société Anonyme à participation publique',
        '01' => 'Société Anonyme'
    ),
    'SARL' => array(
        '02' => 'Société à Responsabilité Limitée'
    ),
    'SCS' => array(
        '03' => 'Société en Commandite Simple'
    ),
    'SNC' => array(
        '04' => 'Société en Nom Collectif'
    ),
    'SP' => array(
        '05' => 'Société en Participation'
    ),
    'GIE' => array(
        '06' => "Groupement d'Intérêt Economique"
    ),
    'ASSO' => array(
        '07' => 'Association'
    ),
    'AUTRE' => array(
        '08' => 'Autre forme juridique'
    ),
    )
);

Configure::write('RelationManager.ActiviteEconomique', array (
    'Agriculture vivrière' => array(
        '001 001' => 'Culture céréalière',
        '001 002' => 'Culture de tubercule et plantains',
        '001 003' => 'Culture de légumes',
        '001 004' => 'Culture de condiments ',
        '001 005' => 'Culture de fruits',
        '001 006' => "Culture d'autres produits de l'agriculture vivrière",
    ),
    "Agriculture industrielle et d'exportation" => array(
        '002 001' => 'Culture de canne à sucre',
        '002 002' => "Culture d'arachide d'huilerie",
        '002 003' => "Culture d'arachide de bouche",
        '002 004' => 'Culture de tabac',
        '002 005' => 'Culture de coton',
        '002 006' => 'Culture de blé',
        '002 007' => 'Culture de cacao',
        '002 008' => 'Culture de café',
        '002 009' => "Culture de bananes d'exportation",
        '002 010' => "Culture d'ananas d'exportation",
        '002 011' => 'Autres cultures industrielles',
    ),
    'Elevage et chasse' => array(
        '003 001' => 'Elevage bovin',
        '003 002' => 'Elevage ovin, caprin, équin',
        '003 003' => 'Elevage de volailles',
        '003 004' => 'Autres élevages',
        '003 005' => 'Chasse',
    ),
    'Sylviculture, exploitation forestière' => array(
        '004 001' => 'Sylviculture',
        '004 002' => 'Exploitation forestière',
    ),
    'Pêche et aquaculture' => array(
        '005 001' => 'Pêche de poissons',
        '005 002' => 'Autres pêches et aquaculture',
    ),
    'Industries extractives' => array(
        '006 001' => "Extraction d'hydrocarbures",
        '006 002' => "Extraction d'autres produits",
    ),
    'Production de viande et de poissons' => array(
        '007 001' => 'Production de viande et de produits à base de viande',
        '007 002' => 'Production de poissons et de produits à base de poissons',
    ),
    'Travail des grains et fabrication de produits amylacés' => array(
        '008 001' => 'Travail de grains et fabrication',
    ),
    'Transformation du café et du cacao' => array(
        '009 001' => 'Transformation du café',
        '009 002' => 'Transformation du cacao',
    ),
    'Industrie des oléagineux' => array(
        '010 001' => 'Huiles brutes et tourteaux',
        '010 002' => 'Autres corps gras',
    ),
    'Boulangerie, pâtisserie et pâtes alimentaires' => array(
        '011 001' => 'Fabrication de pains, de biscuits et de patisserie',
        '011 002' => 'Fabrication de pâtes alimentaires',
    ),
    'Industries laitières' => array(
        '012 001' => 'Industries laitières',
    ),
    "Transform. des fruits et légumes et fabrication d'autres prod. alimentaires" => array(
        '013 001' => 'Fabrication du sucre',
        '013 002' => 'Fabrication de produits à base de fruits et légumes',
        '013 003' => "Fabrication d'autres produits alimentaires",
    ),
    'Industrie des boissons' => array(
        '014 001' => 'Brasseries et malteries',
        '014 002' => "Fabrication d'autres boissons alcoolisées",
        '014 003' => "Fabrication de boissons non alcoolisées et d'eaux minérales",
    ),
    'Industrie du tabac' => array(
        '015 001' => 'Industrie du tabac',
    ),
    "Industries du textile et de l'habillement" => array(
        '016 001' => 'Industries textiles',
        '016 002' => "Industries de l'habillemen",
    ),
    'Industries du cuir et de la chaussure' => array(
        '017 001' => "Fabrication du cuir et d'articles en cuir",
        '017 002' => 'Fabrication de chaussures',
    ),
    'Industries du bois' => array(
        '018 001' => 'Sciage, rabotage et imprégnation du bois',
        '018 002' => 'Fabrication de panneaux en bois',
        '018 003' => "Fabrication d'articles en bois assemblés",
    ),
    "Industries du papier et cartons, de l'édition et de l'imprimerie" => array(
        '019 001' => 'Industrie du papier et carton',
        '019 002' => 'Edition, imprimerie, reproduction',
    ),
    'Raffinage du pétrole' => array(
        '020 001' => 'Raffinage de pétrole Industrie chimique',
        '021 001' => 'Industries chimiques de base',
        '021 002' => "Fabrication de savons, de détergeants et de produits d'entretien",
        '021 003' => 'Fabrication de produits agro-chimiques',
        '021 004' => 'Industries pharmaceutiques',
        '021 005' => "Fabrication d'autres produits chimiques",
    ),
    'Indus du caoutchouc et des plastiques' => array(
        '022 001' => 'Fabrication du caoutchouc naturel',
        '022 002' => 'Industries du caoutchouc',
        '022 003' => 'Fabrication de matières plastiques',
    ),
    "Fabrication d'autres prod minéraux non métalliques et de matériaux de construction" => array(
        '023 001' => 'Industries du verre',
        '023 002' => 'Fabrication de produits minéraux pour la construction',
        '023 003' => "Fabrication d'autres produits minéraux non métalliques",
    ),
    'Métallurgie et travail des métaux' => array(
        '024 001' => 'Métallurgie',
        '024 002' => 'Travail des métaux',
    ),
    "Fabrication de machines, d'équipements et d'appareils électriques"=> array(
        '025 001' => "Fabrication de machines et d'équipements",
        '025 002' => 'Fabrication de machines de bureau',
        '025 003' => "Fabrication d'appareils électriques",
    ),
    "Fabrication d'équipements et appareils audiovisuels et de communication fabrication d'instruments médicaux, d'optique et d'horlogerie" => array(
        '026 001' => "Fabrication d'équipements et appareils audiovisuels et de communication",
        '026 002' => "Fabrication d'instruments médicaux d'optiques et d'horlogerie",
    ),
    'Fabrication de matériel de transport' => array(
        '027 001' => 'Fabrication de véhicules routiers',
        '027 002' => "Fabrication d'autres matériels de transport",
    ),
    'Industries diverses' => array(
        '028 001' => 'Fabrication de meubles',
        '028 002' => 'Industries diverses',
    ),
    "Production et distribution d'eau, d'électricité et de gaz" => array(
        '029 001' => "Production, transport et distribution d'électricité",
        '029 002' => "Captage, épuration et distribution d'eau",
        '029 003' => 'Production et distribution de gaz',
    ),
    'Construction' => array(
        '030 001' => "Préparation de sites et construction d'ouvrages de bâtiment et de génie civil",
        '030 002' => "Travaux d'installation et de finition",
    ),
    'Commerce' => array(
        '031 001' => "Commerce de véhicules, d'accessoires et de carburants",
        '031 002' => "Commerce de produits agricoles bruts et d'animaux vivants",
        '031 003' => 'Autres commerces',
    ),
    'Réparations' => array(
        '032 001' => 'Entretien et réparation de véhicules automobiles',
        '032 002' => 'Réparation de biens personnels et domestiques',
    ),
    'Hôtel, restaurants' => array(
        '033 001' => 'Hôtels',
        '033 002' => 'Bars et restaurants',
    ),
    'Transport et communication' => array(
        '034 001' => 'Transports ferroviaires',
        '034 002' => 'Transports routiers, transports par conduite',
        '034 003' => 'Transports par eau',
        '034 004' => 'Transports aériens',
        '034 005' => 'Services annexes et auxiliaires de transport',
    ),
    'Postes, Télécommunications' => array(
        '035 001' => 'Postes',
        '035 002' => 'Télécommunications',
    ),
    'Activités financière' => array(
        '036 001' => "Services d'intermédiation financière",
        '036 002' => 'Assurances (sauf Sécurité Sociale)',
        '036 003' => "Auxiliaires financiers et d'assurances",
    ),
    'Activités immobilières' => array(
        '037 001' => 'Location de biens immobiliers',
        '037 002' => 'Autres services immobiliers',
    ),
    'Services aux entreprises' => array(
        '038 001' => 'Locations sans opérateurs',
        '038 002' => 'Activités informatiques',
        '038 003' => 'Services rendus principalement aux entreprises',
    ),
    'Administration publique' => array(
        '039 001' => 'Administration générale, économique et sociale',
        '039 002' => 'Services de prérogative publique',
        '039 003' => 'Sécurité sociale obligatoire',
    ),
    'Education' => array(
        '040 001' => 'Education',
    ),
    'Santé et action sociale' => array(
        '041 001' => 'Activités pour la santé des hommes',
        '041 002' => 'Activités vétérinaires',
        '041 003' => 'Action sociale',
    ),
    'Services collectifs, sociaux et personnels' => array(
        '042 001' => 'Assainissement, voirie, et gestion des déchets',
        '042 002' => 'Activités associatives',
        '042 003' => 'Activités récréatives, culturelles et sportives',
        '042 004' => 'Services personnels',
        '042 005' => 'Services domestiques',
    ),
    "Services d'intermédiation financière indirectement mesuré" => array(
        '043 001' => "Services d'intermédiation financière indirectement mesuré",
    ),
    'Correction territoriale' => array(
        '044 001' => 'Correction territoriale',
    ),
    )
);