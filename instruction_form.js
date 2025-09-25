authentification = correct 
=> ça crée une cookie 

ça redérige vers la route /dashboard
la route /dashboard protégé par middleware auth :
condition : la route nous laisse passer si le middleware envoie vrai 
Fonctionnement de auth : 
vérifier si la cookie existe 
auth => vrai 

route nous laisse passer

//---

on rentre sur la route /login
la route /login protégé par middleware guest : 
condition : la route nous laisse passer si le middleware envoie vrai 
Fonctionnement de guest : 
Il renvoie vrai si la cookie n'existe pas 