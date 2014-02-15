DELIMITER $$

DROP PROCEDURE IF EXISTS `export_to_ajaxim`$$

CREATE PROCEDURE `export_to_ajaxim` ()
BEGIN
insert into ajaxim_groups
select id, name from acx_projects
ON DUPLICATE KEY UPDATE group_id = VALUES(group_id), name = VALUES(name); 


insert into ajaxim_users
select id, 
REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(
REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(
REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(
REPLACE(
CONCAT_WS('', first_name, last_name)
, "ě", "e")
, "ř", "r"), "ť", "t"), "š", "s"), "ď", "d"), "č", "c"), "ň", "n"), "é", "e"), "ú", "u"), "í", "i"), "ó", "o")
, "á", "a"), "ý", "y"), "ů", "u"), "ž", "z"),  " ", ""), "Ě", "E"), "Ř", "R"), "Ť", "T"), "Š", "S"), "Ď", "D")
, "Č", "C"), "Ň", "N"), "É", "E"), "Ú", "U"), "Í", "I"), "Ó", "O"), "Á", "A"), "Ý", "Y"), "Ů", "U"), "Ž", "Z")
, md5(password), 0, NOW() from acx_users
ON DUPLICATE KEY UPDATE user_id = VALUES(user_id), username = VALUES(username), password = VALUES(password); 


insert into ajaxim_friends
select  null, acx_project_users.user_id, pu_friends.user_id, acx_project_users.project_id
from acx_project_users join acx_project_users pu_friends ON (acx_project_users.project_id = pu_friends.project_id)
ON DUPLICATE KEY UPDATE user_id = VALUES(user_id), friend_id = VALUES(friend_id), group_id = VALUES(group_id);
END $$

DELIMITER ;