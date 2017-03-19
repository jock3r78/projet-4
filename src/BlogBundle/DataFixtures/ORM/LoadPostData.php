<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 19/03/2017
 * Time: 11:43
 */
namespace BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use BlogBundle\Entity\Post;
use BlogBundle\Entity\Category;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadPostData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $postsData = array(
            array(
                'name' => 'ROAD TRIP EN ÉCOSSE : NORTH COAST 500, LE GUIDE !',
                'content' => '500 miles de bonheur dans les Highlands.

La North Coast 500 est une route de 500 miles (800 km) qui longe les côtes touuut au Nord de l’Ecosse, entre falaises, plages et lochs grandioses, d’Inverness à Torridon. C’est un peu le far North… Wick, John O’Groats, Durness, Lochinver, Applecross,… Et des paysages sauvages à couper le souffle !

Comme pour notre premier road trip en Ecosse, on a aussi déniché des super adresses ! De belles expériences qui font partie intégrante du road trip selon nous. Parce que connaître les bons lieux (l’hôtel cool, la cabane paumée, le ptit resto de fruits de mer…), c’est ce qui rend le voyage inoubliable !

On a donc exploré, creusé, cherché, photographié et avec toutes nos trouvailles on vous a préparé ce guide spécial road trip dans le Nord de l’Écosse, sur la mythique North Coast 500 ! — Enjoy !
Road trip sur la North Coast 500 : l’itinéraire complet
La NC 500, c’est 800 km sur de (très) petites routes ! Il faut prendre son temps, pour avoir le temps de chercher les pépites au fond des baies, les petites routes de traverse, marcher sur les plages désertes…
Pour l’itinéraire complet, on vous conseille entre 4 et 7 jours pleins. Plus si vous poursuivez sur l’île de Skye (+ 2 ou 3 jours) et / ou l’île de Mull (+ 2 ou 3 jours). À cela, ajoutez 2 jours pour faire les trajets A/R depuis et pour l’aéroport (Édimbourg ou Glasgow).
La North Coast 500, c’est une belle boucle le long des Highlands du Nord, qui se prête super bien à un road trip :
Mini guide pratique
		Vous pouvez trouver des billets Paris-Édimbourg à 50€ A/R et des Paris-Glasgow à 70€ A/R avec Easyjet, Vueling, flybe, Air France, HOP!… Comparez à vos dates. Regardez aussi les Paris-Aberdeen, sait-on jamais. Et ici pour les vols directs depuis d’autres villes de France.
		Pour la location de voiture, pas de secret : il faut comparer aussi. Regardez par exemple sur AutoEscape (souvent le moins cher !) ou RentalCars. Passer par des courtiers et/ou des comparateurs donne les meilleurs prix car ils comparent beaucoup de loueurs.
		Sur la North Coast 500, on ne traverse pas beaucoup de villes, et il y a peu de restos, mieux vaut ne pas arriver trop tard si vous voulez manger (bon, je vous rassure, malgré les apparences il y a finalement toujours au moins un pub ouvert somewhere…).
		Le nombre d’hébergements est limité aussi, mieux vaut réserver en avance, surtout si vous y allez en haute-saison (l’été).
		Attention aux midges en été (minis moustiques des Highlands, particulièrement pénibles) : si vous le pouvez, évitez juillet et août ! Si vous n’avez pas le choix, on a entendu du bien de ce spray Avon pour les repousser.
		Une chose à acheter avant de partir : la carte routière de l’Écosse, afin de pouvoir vous y retrouver sur les petites routes. Google maps et les GPS veulent toujours “aller vite”, alors qu’en road trip on veut aller doucement et explorer :) Et rien ne vaut une bonne carte pour ça ! Les Michelin sont top — repérez les routes panoramiques, surlignées en vert = vos meilleures amies.
		Et bien sûr, si vous n’avez pas déjà : 2 ou 3 adaptateurs électriques UK pour recharger vos téléphones et appareils photo.
		Enfin côté guides papier, il y a bien sûr le Lonely Planet, le Routard… Et si vous voulez faire des randos, citons aussi le Walking in Scotland (éd. Lonely Planet, en anglais).
 
 
***
Le road trip sur la North Coast 500 parfait ! Guide, itinéraire et meilleurs spots
Au programme, terres sauvages extraordinaires, lochs sombres mystérieux et adresses cools confidentielles. Le road trip PAR-FAIT.
On a découpé la North Coast 500 — NC500 pour les intimes — en 3 grandes zones :
		CÔTE EST : itinéraire 1 jour → Où dormir,
		CÔTE NORD : itinéraire 1 ou 2 jour(s) → Où dormir,
		CÔTE OUEST : itinéraire 2 à 4 jours → Où dormir.
Avec des numéros complémentaires comme l’île de Skye et l’île de Mull, qui sont hors tracé officiel de la route mais qui valent carrément mille fois le voyage si vous avez le temps !! Et un retour par Glen Coe ;)
North Coast 500, c’est parti !   
CÔTE EST : 1 jour
La partie Est de la route est sans doute celle qu’on a trouvé la moins ébouriffante. Il y a moins de relief et c’est moins sauvage que le Nord, et surtout l’Ouest.
Notre recommandation, c’est de prendre 1 jour pour remonter le long de la côte, d’Inverness jusqu’à Wick et de dormir dans le château (hanté) d’Ackergill : c’est clairement THE expérience de dingue de la journée !!
',
                'episode' => '1',
                'photo' => 'http://lorempixel.com/750/500/nature/',
                'photoresume' => 'http://lorempixel.com/600/200/nature/',
            ),
            array(
                'name' => 'UN SUPERBE ROAD TRIP DANS LES ALPES BAVAROISES !',
                'content' => 'Nous avons fait un superbe road trip d’une semaine en Bavière, tout au Sud de l’Allemagne, du côté des Alpes !
Le timing et la saison, en été (début septembre) étaient parfaits. En 1 semaine, vous pouvez explorer le Parc National de Berchtesgaden (4 jours) et la région de Garmisch-Partenkirchen (3 jours). Pour finir en beauté avec le fameux château de Neuschwanstein !
Les Alpes bavaroises sont à moins de 2h de Munich, la capitale de la Bavière, tout au Sud de l’Allemagne. Il y a par là-bas de beaux sommets qui avoisinent les 3 000 mètres, quelques lacs cristallins et de très belles routes alpines !
C’est parti pour un itinéraire bien cool dans les Alpes bavaroises, avec les belles adresses trouvées sur la route, nos plus beaux spots, lacs et montagnes à visiter !

ROAD TRIP DANS LES ALPES BAVAROISES : LA VIDÉO !
Qui a dit que l’Allemagne n’avait pas de beaux paysages ? C’est clairement une idée reçue : on en a pris plein les yeux ! Le voyage a été riche en paysages à couper le souffle, téléphériques terrifiants, routes sublimes et belles adresses.
Une semaine au cœur des Alpes de Bavière offre des images inoubliables et de très beaux souvenirs : l’accueil des Bavarois et une nature grandiose !
ALPES DE BAVIÈRE : CARTE DE NOTRE ROAD TRIP D’1 SEMAINE
Accessibles facilement depuis Munich, notre itinéraire est presque tout le temps sur la “Route Allemande des Alpes”, alias la “Deutsche Alpenstrasse”, sauf que nous zappons la partie Ouest à la fin. La route se termine officiellement au lac de Constance (Bodensee en allemand), mais nous nous arrêtons (en beauté !) au château de Neuschwanstein.
Pour louer une voiture, on aime bien AutoEscape qui compare beaucoup de loueurs et donne de très bons prix ! Une voiture économique suffit amplement pour faire ce road trip.
',
                'episode' => '2',
                'photo' => 'http://lorempixel.com/750/500/nature/',
                'photoresume' => 'http://lorempixel.com/600/200/nature/',
            ),
            array(
                'name' => 'ROAD TRIP DANS LES DOLOMITES : AU CŒUR DES ALPES ITALIENNES !',
                'content' => 'Il est temps de reprendre la route ! C’est un voyage tout à fait unique que nous partageons : l’Italie, plus précisément les Dolomites au cœur du Sud-Tyrol 🇮🇹 !
Les Dolomites ! Ce seul nom trottait dans nos têtes depuis quelques années déjà. Les Dolomites ! Icônes et montagnes italiennes, récemment classées par l’UNESCO au Patrimoine Mondial !
Nous avons parcouru durant quelques jours le Sud-Tyrol, logé tout au Nord de la «Grande Botte». Région où les saveurs alpines et méditerranéennes se télescopent et donnent une saveur toute particulière à l’exploration.
Belles adresses, inspiration photographique bien sûr, routes sublimes et petite surprise à l’italienne : prise de vue aérienne 🙊 !!!!
Mini-guide pratique
		Vous pouvez trouver un billet aller-retour Paris-Venise dans les 35€ avec Ryanair ou Easyjet en vous y prenant à l’avance ! Transavia et Vueling ont de bons prix aussi. Les aéroports les plus proches sont Innsbruck ou Vérone, et bonne nouvelle : il y a des vols directs Paris-Vérone sur Transavia ! Sinon, un peu plus loin, cela peut être aussi Milan (Bergame ou Malpensa), ou encore Munich.
		Pour la location de voiture, pas de secret : il faut comparer. Regardez sur AutoEscape ou RentalCars ! Passer par des courtiers et/ou des comparateurs vous donne toujours les meilleurs prix !
		Comme toujours, on vous conseille d’acheter la carte Michelin de la région, car c’est le meilleur moyen de bien faire vos choix d’itinéraires une fois sur place ! Suivez les routes le plus sinueuses, celles qui passent entre les montagnes, et les routes vertes sur la carte (= panoramiques) : ce sont les plus belles !
		Un guide pour les randonnées (gros sujet !) : Short walks in the Dolomites (en anglais)
 
Un petit point culture
La grande particularité du Sud-Tyrol, c’est qu’il y a une double culture austro-italienne qui rend la région super unique et intéressante !
Les habitants parlent 3 langues : l’allemand, l’italien et le ladin, une ancienne langue rhéto-romane. La langue ladine est minoritaire et parlée surtout du côté de Val Gardena et de Val Badia.
On est bel et bien en Italie, pourtant l’allemand est la langue que l’on entend le plus ! En fait, la région faisait partie de l’Autriche jusqu’en 1919 et n’est devenue italienne qu’après la Première Guerre mondiale ! Elle a son autonomie régionale depuis 1972. Vous voilà prévenus ! #RévisezVotreDeutsch (bon, bien sûr, si vous parlez italien tout le monde vous comprendra !)
Bien sûr, on retrouve cette double culture dans tous les domaines, dont l’architecture, mais je crois que c’est le résultat en cuisine qui est le plus délicieux ! :) Last but not least, si vous voulez vous faire plaisir, sachez que le Sud-Tyrol est une région de bons vins et…. qu’il y a ici 23 étoiles Michelin. Voilà, voilà. (Ok, si vous insistez, la prochaine fois on les teste toutes).
',
                'episode' => '3',
                'photo' => 'http://lorempixel.com/750/500/nature/',
                'photoresume' => 'http://lorempixel.com/600/200/nature/',
            ),
            array(
                'name' => '5 COUPS DE CŒUR POUR VISITER LA BELLE VIENNE ! — CITY GUIDE',
                'content' => 'Vienne est une très belle ville que nous avons eu la chance de visiter en juillet pour un week-end de 3 jours ! Elle a été la dernière étape de notre superbe road trip en Autriche !
Alors, que visiter à Vienne en quelques jours ? C’est parti pour une sélection de nos plus belles adresses et coups de cœur, trucs cools à voir et à faire !
1. La Bibliothèque Nationale d’Autriche
Vous connaissez notre amour pour les bibliothèques (celle de Linz nous avait enchanté quelques jours plus tôt, et on pense toujours avec émotion à celles de Dublin et, dans un tout autre genre : Stuttgart !). Une étape à Vienne nous permet de visiter cette fois l’Österreichische Nationalbibliothek.
Oui, la Bibliothèque Nationale d’Autriche… Une merveille !
Elle est très grande, impressionnante même. Plus de 7 millions de documents, livres, cartes géographiques des premières découvertes, globes terrestres uniques, papyrus,… Le fonds est d’une très grande richesse.
La photographie a été réalisée dans la Salle d’Apparat (Prunksaal) de la bibliothèque. Un espace baroque incroyable du 18ème siècle. 200 000 volumes sont stockés dans ces murs. Un grand nombre de panneaux couverts d’ouvrages s’ouvrent pour laisser place à d’autres espaces. Labyrinthe extraordinaire classé à l’UNESCO.
C’est un lieu de culture et de savoir merveilleux.
Visite : 7€/personne (incluse dans le Vienna Pass).

2. Le Quartier des Musées
Le Museum Quarter est définitivement un de nos quartiers préférés de Vienne ! Un bonheur pour les amateurs de musées !
C’est un quartier piéton, articulé autour de nombreux musées et ponctué de restaurants, de librairies, de cafés… — Ok, abandonnez-moi là.
Sachez que c’est l’un des plus grands centres culturels au monde, 60 000 m2 excusez du peu.
Au niveau des musées, vous vous doutez donc qu’il y a de quoi faire ! Vous trouverez toute la liste ici. On a beaucoup aimé ces deux-là :
		Le Musée Leopold qui abrite une grande collection Egon Schiele et Gustav Klimt. La grande salle d’entrée est immense, un superbe espace qui joue avec les ombres,
		Le fameux MUMOK, le musée d’Art Moderne, à l’architecture cubique étonnante.
3. L’École Espagnole d’Équitation de Vienne
Classique et immanquable, un petit tour par l’École Espagnole d’Équitation de Vienne s’impose, surtout si vous aimez les chevaux. C’est une école mondialement connue ! L’entraînement du matin donne une idée du travail que les écuyers effectuent, pendant des années, avec leur lipizzan.
Le lieu dans lequel on peut voir les entraînements le matin (à 10 heures généralement) est historique. C’est le manège d’hiver du Palais Impérial, rien que ça… Un manège couvert magnifique, avec des lustres impressionnants, des balcons, des fresques.
Au centre, sur la terre battue, on peut admirer le ballet des étalons purs-sangs lippizans, en musique. Il n’y a rien de spectaculaire à proprement parler, surtout si on n’est pas spécialiste de l’équitation (certains mouvements sont visiblement très difficiles à faire avec un cheval).
C’est surtout l’ensemble qui est intéressant, le décor, l’ambiance. Les purs-sangs qui dansent ensemble, la terre battue qui vole, les gradins chics dans lesquels on imagine se presser les femmes en toilette d’époque, sous l’œil de l’Empereur et des lustres monumentaux.
L’entrée pour la séance d’entraînement du matin (durée : 1 heure environ) coûte 15€/personne (incluse dans le Vienna Pass).
',
                'episode' => '4',
                'photo' => 'http://lorempixel.com/750/500/nature/',
                'photoresume' => 'http://lorempixel.com/600/200/nature/',
            ),
            array(
                'name' => 'ROAD TRIP EN CATALOGNE : LES PLUS BELLES ROUTES ET PAYSAGES DES PYRÉNÉES !',
                'content' => 'Nous avons fait un beau road trip d’automne d’une semaine dans le Nord de la Catalogne !
La lumière et les couleurs catalanes ont su inspirer les plus grands artistes. Joan Miró, Pablo Picasso, Salvador Dalí, Antoni Tàpies,… Picasso parle de la Catalogne comme d’une terre «de douces et insolentes beautés».
C’est sur ces terres du Nord-Est de l’Espagne que nous nous sommes perdus quelques jours, en octobre. Partons explorer les Pyrénées catalanes et ses superbes couleurs d’automne 🍃🍂
Routes de montagnes, lacs, forêts, petits villages et jolies adresses…

ROAD TRIP EN CATALOGNE : LA VIDÉO !
On a monté quelques rushs de notre expérience catalane. Une minute d’atmosphères, de lumières et de beaux endroits ; un petit “behind the scene” tout à la fin, si vous voulez nous voir… un peu :)
On espère que cela vous plaira !

1 SEMAINE DANS LES PYRÉNÉES CATALANES : LA CARTE
Un magnifique road trip où la lumière d’automne a porté notre prise de vue. Des noirs très denses, un bleu très singulier, des verts profonds, des tons chauds magnifiques. Une belle expérience de photographie !
VISITER LES PYRÉNÉES CATALANES
On vous livre nos coups de cœur dans les Pyrénées catalanes, côté Espagne donc !
Le superbe Parc National d’Aiguestortes et ses lacs !
Uns de nos endroits préférés dans les Pyrénées catalanes, car tout simplement superbe.
Le Parc Nacional d’Aigüestortes i Estany de Sant Maurici accueille le voyageur par quelques chemins discrets et de sublimes forêts automnales.
On y accède à pied ou par «taxis-locaux», à heure fixe, afin d’éviter l’invasion automobile. Au bout du chemin : les lacs de Llong et de Llebreta ainsi que le superbe Planell d’Aigüestortes. C’est ce qu’on a fait et c’était très cool !
Les voitures partent du village de la place du Treio de Boí, petit village non loin du Parc.
Il y a deux entrées possibles au Parc National d’Aiguestortes : Espot (Pallars Sobirà), côté Est, et Boí (Alta Ribagorça) côté Ouest. Dans ces deux villages, on trouve des centres d’accueil, infos, services basiques et transport.
Si vous voulez voir le lac Saint Maurice, sachez qu’il faut plutôt viser l’entrée Est par Espot ! Du côté de Boi, c’est possible aussi mais c’est une longue rando (on nous a dit 4 ou 5 heures). Du coup, on l’a raté mais avec regret parce qu’il a l’air super beau !!
Le parcours classique côté Ouest (par Boi) est la visite du plateau d’Aiguestortes et du lac Llong. Temps total : 2h30 Dénivelé : 290 mètres Si vous voulez, vous pouvez zapper la partie en voiture à partir du tremplin de la Molina mais il faut alors compter 2 heures de plus de marche.
Retrouvez d’autres randos possibles ici ou encore ici.
',
                'episode' => '5',
                'photo' => 'http://lorempixel.com/750/500/nature/',
                'photoresume' => 'http://lorempixel.com/600/200/nature/',
            ),
            array(
                'name' => 'TOKYO — INSPIRATION PHOTOGRAPHIQUE, BELLES ADRESSES ET GUIDE PRATIQUE',
                'content' => 'Nous rentrons d’un superbe voyage de 15 jours au Japon, à la découverte de trois villes emblématiques : l’hyper-contemporaine Tokyo, la traditionnelle Kyoto et la «food-wahou» Osaka !
Exploration initiatique et merveilleuse de la culture nippone ! Des ambiances humaines, morales, psychologiques, photographiques très fortes, nous appelant à ressentir le «Wa» — philosophie de l’équilibre reliant les Japonais les uns aux autres, et au monde.
C’est un beau reportage que nous avons réalisé pour Travel by Air France, les guides de voyage de la compagnie. Air France est avec nous depuis les tout débuts du blog, dès 2007, c’est avec d’autant plus de plaisir que nous travaillons ensemble régulièrement !
On vous emmène d’abord visiter la magnétique et incroyable Tokyo, suivez le guide !

VOYAGER AU JAPON
Un voyage au Japon est une expérience unique. Au-delà de la langue et de l’éloignement géographique, la perte de repères est réelle — plus impliquante qu’il n’y parait. On se dit qu’une grande ville reste une grande ville, qu’un hôtel reste un hôtel,… il n’en est rien.
Le Japon est une destination complexe, sobre, se révélant très doucement aux yeux du voyageur-photographe. Je dirais que le regard doit s’affranchir de cette quête du “stunning”, du “amazing” et rentrer dans une autre exploration : celle du détail, de l’esthétique humble, de l’harmonie en toute chose.
Difficile, excitant !
Quand partir au Japon ?
C’est un point important ! Nous sommes partis en fin d’automne, sur la deuxième quinzaine du mois de novembre. D’un point de vue température / météo, c’était agréable. Peu de jours de pluie, de très belles journées, des températures tout de même fraîches bien sûr, allant de 11° à 16°C entre Tokyo, Kyoto et Osaka. Pas mal du tout !
L’AUTOMNE (de septembre à novembre)
L’automne au Japon est plus qu’une saison, c’est un événement durant lequel les érables (momiji), les ginkgos et tous les jardins s’embrasent. La contemplation de la nature occupe une place très importante dans la culture nippone. Spectaculaire, hyper-photogénique mais… complètement bondé ! Les taux d’occupation dans les hôtels (ryokans, airbnb,…) et les lieux de visites du Kansai atteignent leur maximum !! La foule est telle qu’elle peut rebuter, il est donc important de bien préparer ses journées et ses itinéraires pour profiter des lieux sans trop jouer des coudes. On vous en parle plus bas.
Note : les journées sont plutôt courtes, la lumière devient faible à partir de 16h30 / 17h. La “belle lumière du soir” se joue en quelques minutes. Si la photographie est au cœur de votre exploration du Japon, cet élément n’est pas anodin ;)
 
LE PRINTEMPS (de mars à mai)
Le printemps, c’est l’autre saison star du Japon. Celle des cerisiers en fleurs (sakura). La encore, la folie gagne les villes et les grands lieux touristiques. Les japonais vouent une passion immodérée pour cette période où ils vont s’installer dans les jardins. Si vous privilégiez cette saison, il est absolument indispensable de réserver tous vos pied à terre des mois à l’avance !! L’improvisation en pleine Golden Week peut coûter très cher !
 
L’ÉTÉ (de juin à août)
La chaleur et la moiteur s’installent, de jour comme de nuit ! Il fait lourd, le ciel est blanc et moins photogénique. La foule est moins dense sur les grands spots touristiques et sera plus concentrée sur les festivals d’été.
C’est le grand avantage de cette saison : les festivals sont nombreux ! Ils sont très populaires dans la culture japonaise, si vous le pouvez essayez d’en expérimenter un. En voici quelques uns : Sanno Matsuri à Tokyo, Gion Matsuri à Kyoto, Warei Taisai / Uwajima Ushi-Oni Matsuri à Uwajima, Tenjin Matsuri à Osaka, Nachi No Hi Matsuri aux Monts Kumani… De sublimes manifestations traditionnelles à voir et photographier ! Un must !
 
L’HIVER (de décembre à février)
Voilà une saison qu’on adorerait découvrir ! On a en tête les vapeurs fumantes d’un onsen en pleine nature, bordé de neige… Un autre visage du Japon.
Il peut faire froid bien sûr, sur la grande île d’Honshū, toutefois les atmosphères du Japon, avec les belles lumières d’hiver et les grands ciels dégagés, sont sublimes ! La neige est présente en montagne et s’invite régulièrement dans les forêts entourant Kyoto ! Peu voire pas de monde, idéal pour réaliser de magnifiques séries photo ! Si les températures froides ne vous rebutent pas, cette période peut être elle aussi un must !
 
Mémo Calendrier : Haute Saison : Avril / Mai / Août / Novembre Saison intermédiaire : Juin / Juillet / Septembre / Octobre / Décembre Basse saison : Janvier / Février / Mars
',
                'episode' => '6',
                'photo' => 'http://lorempixel.com/750/500/nature/',
                'photoresume' => 'http://lorempixel.com/600/200/nature/',
            )
        );
        // Get our userManager, you must implement `ContainerAwareInterface`
        $userManager = $this->container->get('fos_user.user_manager');
        // Create our user and set details
        $user = $userManager->createUser();
        $user->setUsername('Jeanforteroche');
        $user->setEmail('jean@forteroche.com');
        $user->setPlainPassword('admin');
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_ADMIN'));
        // New Category
        $category = new Category();
        $category->setName('Episode');
        $category->setNumberPost(0);
        foreach ($postsData as $postData) {
            $post = new Post();
            $post->setUser($user);
            $post->setCategory($category);
            $post->setName($postData['name']);
            $post->setContent($postData['content']);
            $post->setEpisode($postData['episode']);
            $post->setPhoto($postData['photo']);
            $post->setPhotoresume($postData['photoresume']);

            $manager->persist($post);
        }
        $manager->flush();
    }
}