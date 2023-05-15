create user 'visiteur'@'localhost' identified by 'VisiteurGr33n';

GRANT
SELECT ON greengarden.t_d_produit TO 'visiteur'@'localhost' ;


create user 'client'@'localhost' identified by 'ClientGr33n';

GRANT
SELECT ON greengarden.* TO 'client'@'localhost' ;

GRANT
insert,
update ON greengarden.t_d_client TO 'client'@'localhost' ;

GRANT
insert,
update ON greengarden.t_d_commande TO 'client'@'localhost' ;


create user 'gestion'@'localhost' identified by 'G3sti0nGr33n';

GRANT
select,
update,
insert,
delete ON * TO 'gestion'@'localhost';


create user 'admin'@'localhost' identified by 'AdminGr33n';

GRANT all ON * TO 'admin'@'localhost' WITH GRANT OPTION;

