# Tp-Api-Ormhttps://github.com/Ryovenly/Tp-Api-Orm/edit/master/README.md


    Quel est l'intérêt de créer une API plutôt qu'une application classique ?
    Une API permet de partager ses données sur internet, ainsi les autres développeurs peuvent centraliser ses données dans leurs inventaire et  
    les utiliser comme bon leurs semblent.
    
    Résumez les étapes du mécanisme de sérialisation implémenté dans Symfony
    Seriazalisation des éléments :
    1ère étape : la Normalisation (créer un objet en tableau)
    2ème étape : l’encodage 

    
    Qu'est-ce qu'un groupe de sérialisation ? A quoi sert-il ?
    La sérialisation consiste à transformer un objet en un format spécifique ( json) puis de pouvoir passer du format spécifique vers l’objet d’origine. Cela permet ainsi de pouvoir transporter les données sur plusieurs plateforme selon le format requis.
    
    Quelle est la différence entre la méthode PUT et la méthode PATCH ?
    La méthode PUT permet de modifier entièrement la donnée qu'on veut modifier tandis que la méthode PATCH permet de modifier partiellement en ciblant les données qu'on veut modifier tout en laissant les autres données d'origine qu'on ne touche pas.
    
    Quels sont les différents types de relation entre entités pouvant être mis en place avec Doctrine ?
    OneToOne,OneToMany et ManyToMany
    
    Qu'est-ce qu'un Trait en PHP et à quoi peut-il servir ?
    Un trait est une sorte de class qui regroupe plusieurs méthodes. On peut ainsi utiliser les différentes méthodes du Trait sans passer par l'héritage
