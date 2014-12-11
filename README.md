# Start-up d'un projet Wordpress<span id="start-up-dun-projet-wordpress"></span>

Si vous aidez sur un projet déjà démarré, allez directement à **Aider sur un projet Wordpress**

## Contenu

- [Start-up d'un projet Wordpress](#start-up-dun-projet-wordpress)
    - [Exigences](#exigences)
    - [Installer Composer](#installer-composer)
    - [Installation et utilisation](#installation-et-utilisation)
    - [Setup du Git](#setup-du-git)
    - [Changer la langue de l'admin de Wordpress](#changer-la-langue-de-ladmin-de-wordpress)
    - [Plugins Wordpress](#plugins-wordpress)
        - [Exemple](#exemple)
        - [A propos des versions des plugins](#a-propos-des-versions-des-plugins)
- [Aider sur un projet Wordpress](#aider-sur-un-projet-wordpress)
- [Déployer avec Capistrano](#dployer-avec-capistrano)
    - [Étapes de déploiement](#tapes-de-dploiement)

## Exigences<span id="exigences"></span>

* Git
* PHP >= 5.4 (pour Composer)
* Ruby >= 1.9 (pour Capistrano, seulement pour faire un déploiement)

## Installer Composer<span id="installer-composer"></span>

_Si vous avez déjà Composer, passez à l'étape suivante **Installation et utilisation**_

**Pour Mac**: utilisez les commandes suivantes :

	curl -sS https://getcomposer.org/installer | php
	mv composer.phar /usr/local/bin/composer

Pour plus d'information [Get Composer Mac](https://getcomposer.org/doc/00-intro.md#installation-nix)


**Pour Windows**: Téléchargez et installez [Composer](https://getcomposer.org/Composer-Setup.exe)

Pour plus d'information [Get Composer Windows](https://getcomposer.org/doc/00-intro.md#installation-windows)

## Installation et utilisation<span id="installation-et-utilisation"></span>

**Note: Pour faciliter la gestion du contenu et de la database Wordpress, nous vous conseillons de faire une demande pour le setup d'un serveur de développement ainsi qu'une database pour votre projet. Cela évitera d'avoir à exporter et importer des bases de données sans cesse!**

1. Dans votre terminal, assurez-vous d'être au path root de votre environnement local, exemple : `/Applications/MAMP/htdocs/`.
2. Utilisez la commande suivante :

		composer create-project roots/bedrock --stability="dev" --repository-url=http://serveurdedev.ca/satis/ <nom-du-projet>
	
	_Remplacez `<nom-du-projet>`, et gardez l'espace qui le précéde._
	
3. Répondre **"yes"** aux questions **"Generate salts and append to .env file?"** et **"Do you want to remove the existing VCS (.git, .svn..) history?"**
4. Ouvrez `.env` ( _situé à la racine de votre nouveau projet_ ) à l'aide de votre éditeur de texte préféré et insérez les informations de votre database local ou remote.
	* `DB_NAME` - Nom de la database
	* `DB_USER` - User de la database
	* `DB_PASSWORD` - Mot de passe de la database
	* `DB_HOST` - Le host de la database
	* `WP_ENV` - Spécifier l'environment (`development`, `staging`, `production`)
	* `WP_HOME` - URL de votre site (http://example.com)
	* `WP_SITEURL` - URL vers Wordpress (http://example.com/wp)
5. Utilisez la commande suivante : 

		cd <nom-du-projet>

	_Remplacez `<nom-du-projet>`._
	
5. Utilisez la commande suivante : 

		mkdir -p ./web/app/themes/<nom-du-projet>/ && git archive --remote=git@projets.o2web.ca:cthibault/wp-blanked-theme.git master | tar -x -C ./web/app/themes/<nom-du-projet>/

	_Remplacez `<nom-du-projet>` aux deux endroits._
	
6. Utilisez la commande suivante : 

		git archive --remote=git@projets.o2web.ca:cthibault/base-sass.git master | tar -x -C ./web/app/themes/<nom-du-projet>/assets/

	_Remplacez `<nom-du-projet>`._
 
7. Configurez votre serveur Apache (MAMP ou XAMPP) pour que le root pointe sur exemple : `/Applications/MAMP/htdocs/<nom-du-projet>/web/`
8. Allez sur votre adresse locale, exemple: `http://localhost:8888`, configurez le Wordpress!
9. Et voilà!


## Setup du Git<span id="setup-du-git"></span>

Un simple rappel qu'il serait maintenant temps de créer votre projet sur Git et d'y mettre vos fichiers de base avant de commencer votre développement.

1. Créez votre projet sur [Gitlab](http://projets.o2web.ca/gitlab/projects/new)
2. Faites les commandes suivantes dans votre terminal à la racine de votre projet :
	* `git init`
	* `git checkout -b develop` 
	
  		_Il est conseillé d'utiliser une branche **"develop"** pour votre développement et non **"master"**._
	* `git commit -m "first commit" -a`
	* `git remote add origin git@projets.o2web.ca:<votre-nom>/<nom-du-projet>.git` 
	
  		_Cette ligne vous est fourni dans les étapes suivant la création de votre projet._
	* `git push -u origin develop`
	
## Changer la langue de l'admin de Wordpress<span id="changer-la-langue-de-ladmin-de-wordpress"></span>

Par défaut, Wordpress est installé en anglais. Si vous désirez avoir l'admin en une autre langue(français par exemple), juste a changer la variable 

	define('WPLANG', '');

dans le fichier `config/application.php` par:

	define('WPLANG', 'fr');
	
Dans le cas très improbable où vous auriez a installer wordpress dans une autre langue, vous pouvez ajouter

	"koodimonni-language/<votre code de langue ici>": "dev-master",
	
au packages requis dans composer. La liste disponible est ici: [http://languages.koodimonni.fi/](http://languages.koodimonni.fi/)
	

## Plugins Wordpress<span id="plugins-wordpress"></span>

Les plugins que nous utilisons couramment sont déjà inclus dans le composer.json, Ils seront donc déjà installés dans votre projets. Ceci inclus **Advanced Custom field** et toutes ses extensions. Pour installer un plugin wordpress gratuit (disponible dans le [plugin directory](https://wordpress.org/plugins/)), procédez comme suit:

* Trouver le nom du package / plugin qu'on veut installer en se référant au [wordpress plugin directory](https://wordpress.org/plugins/).
* Trouver le package associé sur [Wp-Packagist](http://plugins.svn.wordpress.org/) 
* Ajouter le plugin au fichier composer.json

### Exemple<span id="exemple"></span>

Sur le site de wordpress: **[Intuitive Custom Post Order](http://wordpress.org/plugins/intuitive-custom-post-order/changelog/)**

Sur le le repo packagist: [http://plugins.svn.wordpress.org/intuitive-custom-post-order/](http://plugins.svn.wordpress.org/intuitive-custom-post-order/)

Utiliserait la commande suivante dans le terminal pour l'ajouter au projet :

	composer require wpackagist-plugin/intuitive-custom-post-order:dev-trunk
	
### A propos des versions des plugins<span id="a-propos-des-versions-des-plugins"></span>

Par défaut, les plugins vont avoir une version courante, considérée comme la version la plus récente, appelée `dev-trunk`.

Pour verrouiller l'installation à une version particulière, vous pouvez utiliser les tags de version tels qu'il apparaissent dans le changelog du plugin de wordpress.

Seulement les tags numériques sont valides:

* 3.9.x-dev (non valide)
* 3.9.2 (valide)

# Aider sur un projet Wordpress<span id="aider-sur-un-projet-wordpress"></span>

**Note : Ceci est pour faire une installation local seulement.**

1. Dans votre terminal, assurez-vous d'être au path root de votre environnement local, exemple : `/Applications/MAMP/htdocs/`.
2. Git clone du projet sur lequel vous devez aider ` git@projets.o2web.ca:<nom-du-master>/<nom-du-projet>.git`
3. Déplacez-vous au root du projet `cd <nom-du-projet>`
4. Utilisez la commande suivante: `composer run-script post-root-package-install`
5. Utilisez la commande suivante: `composer install`
6. Utilisez la commande suivante: `composer update`
7. Ouvrez `.env` ( _qui se situe au root du projet_ ) à l'aide de votre éditeur de texte et insérez les informations de database local ou remote.
	* `DB_NAME` - Nom de la database
	* `DB_USER` - User de la database
	* `DB_PASSWORD` - Mot de passe de la database
	* `DB_HOST` - Le host de la database
	* `WP_ENV` - Spécifier l'environment (`development`, `staging`, `production`)
	* `WP_HOME` - URL de votre site (http://example.com)
	* `WP_SITEURL` - URL vers Wordpress (http://example.com/wp)
8. Configurez votre serveur Apache (MAMP ou XAMPP) pour que le root pointe sur exemple : `/Applications/MAMP/htdocs/<nom-du-projet>/web/`

# Déployer avec Capistrano<span id="dployer-avec-capistrano"></span>

Gems requis:

* capistrano (> 3.2.0)
* capistrano-composer

Ils peuvent être installés à l'aide de la commande : `gem install <nom-du-gem>` mais nous recommandons d'utiliser [Bundler](http://bundler.io/). Bundler est simplement l'équivalent Ruby de Composer. Tout comme Composer gère les dépendances/packages PHP, Bundler gère les dépendances/gems Ruby. Bundler est lui même un Gem et peut être installé avec la commande : `gem install bundler` (sudo peut être requis).

Le `Gemfile` au root du repo specifie les Gems requises (au même titre que `composer.json`). Une fois Bundler installé, exécutez 

	bundle install
	
pour installer le Gem dans le `Gemfile`. En utilisant Bundler, vous devrez prefixer la commande `cap` avec `bundle exec` comme illustré plus bas (ce qui garanti que vous n'utilisez pas de Gems qui peut provoquer des conflits).

Voir [http://capistranorb.com/documentation/getting-started/authentication-and-authorisation/](http://capistranorb.com/documentation/getting-started/authentication-and-authorisation/) pour la meilleure façon de mettre en place des authentifications de clé SSH à vos serveurs de sans mot de passe (et sécuriser) le déploiement.

## Étapes de déploiement<span id="tapes-de-dploiement"></span>

**VÉRIFIEZ QUE VOTRE CODE EST COMMITÉ ET PUSHÉ DANS LA BONNE BRANCHE AVANT DE LANCER LE DÉPLOIEMENT**

1. Éditez `config/deploy/<stage>.rb` et `config/deploy.rb` avec les options de connexion et paramètres nécessaires au déploiement.
2. Avant votre premier déploiement, utilisez la commande suivante pour créer les dossiers/symlinks nécessaires:
	
		bundle exec cap <stage> deploy:check


	Note : Si l'étape 2 retourne une erreur de login, utilisez la commande suivante avant de refaire l'étape 2 à nouveau :
	
		ssh-copy-id <user>@<host>
		
	**Alternativement**, si vous n'avez pas installé ssh-copy-id, vous pouvez utiliser la commande suivante (qui est équivalente):

		cat ~/.ssh/id_rsa.pub | ssh <user>@<host> 'mkdir -p .ssh && touch .ssh/authorized_keys && cat >> .ssh/authorized_keys'
		
	_Remplacez `<user>` et `<host>`._
	
	**ATTENTION:** n'oubliez pas dans tous les cas de charger votre clef ssh dans *l'agent SSH* en utilisant la commande suivante si vous éprouvez des problèmes de connexion.
	
		ssh-add
		
	Vous devriez recevoir une réponse indiquant que votre clé ssh a été chargée ex: *Identity added: /Users/louim/.ssh/id_rsa (/Users/louim/.ssh/id_rsa)*
	
	Vous aurez une **erreur** spécifiant que le fichier `.env` est manquant, procédez à l'étape 3. **Ceci est normal**.
	
3. Ajoutez le fichier `.env` (changez les informations nécéssaires une fois le fichier transféré) au dossier `shared/` dans le path `<deploy_to>` (spécifié dans le fichier deploy.rb) sur le remote server (ex: `/home/<user>/<nom-de-l'application>/<stage>/shared/.env`)
4. Utilisez la commande de déploiement :

		bundle exec cap <stage> deploy

	_Remplacez `<stage>` par "staging" ou "production" dépendant de votre besoin._
5. *(Optionnel)* Utilisez la commande `bundle exec cap <stage> uploads:sync` Pour synchroniser les fichiers uploadés entre votre version locale et le serveur. **Attention, il s'agit d'une synchronisation bidirectionnelle.** Pour synchroniser les fichier entre le `staging` et la `production`, utilisez `bundle exec cap staging uploads:sync` pour ramener les uploads puis `bundle exec cap production uploads:sync` pour les envoyer en production.

### wp-cron

Bedrock Désactive le WP Cron via `define('DISABLE_WP_CRON', true)`;. Si vous avez besoin des fonctionalitées du cron de Wordpress (exemple les post qui se publient à une heure précise), vous devez aller ajouter un cronjob dans le crontab manuellement:

	*/5 * * * * curl http://<website_url>/wp/wp-cron.php
