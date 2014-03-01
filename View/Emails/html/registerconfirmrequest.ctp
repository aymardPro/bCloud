<p>Bienvenue <?php echo $fullname; ?></p>

<p>Nous venons d'enrégister votre inscription sur la plateforme bCloud Entreprise!.</p>

<p>
	Vos informations de connexion sont les suivantes:
	<ul>
		<li>Login: <strong><?php echo $email; ?></strong></li>
		<li>Mot de passe: <strong><?php echo $password; ?></strong></li>
	</ul>
</p>

<p>
	Afin de vous connecter et bénéficier de nos services, vous devez obligatoirement confirmer votre compte en cliquant sur 
	le lien suivant (ou le copier/coller dans votre barre d'adresse):
	<ul>
		<li>Lien de confirmation: 
			<strong><a href="<?php echo $token_link; ?>" title="Lien de confirmation"><?php echo $token_link; ?></a></strong>
		</li>
	</ul>	
</p>

<p>Merci d'utiliser bCloud Entreprise!</p>