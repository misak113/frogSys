-- by union

select *, id_domaci as id_tymu, nazev, id_kola, kontumace
/*
sum(utkani_domaci_vyhraly) as vyhry,
sum(utkani_hoste_vyhraly) as prohry,
sum(utkani_remiza) as remizy,
sum(domaci_skore) as skore_plus,
sum(hoste_skore) as skore_minus,
sum(utkani_domaci_vyhraly)*2 + sum(utkani_remiza) as body
*/

from (

(
# 1-UNION
select id_domaci, id_kola, utkani_remiza,

sum(utkani_domaci_vyhraly) as utkani_domaci_vyhraly,
sum(utkani_hoste_vyhraly) as utkani_hoste_vyhraly,

sum(IF(utkani_hoste_vyhraly, kontumace, 0)) as kontumace,
sum(zapas_domaci_vyhraly_skore) as domaci_skore,
sum(zapas_hoste_vyhraly_skore) as hoste_skore

from
(
# 2-SUBQUERY
select id_kola, id_utkani, kontumace, id_host, id_domaci,

sum(zapas_domaci_vyhraly) as zapas_domaci_vyhraly_skore,
sum(zapas_hoste_vyhraly) as zapas_hoste_vyhraly_skore,

sum(zapas_hoste_vyhraly) < sum(zapas_domaci_vyhraly) as utkani_domaci_vyhraly,
sum(zapas_hoste_vyhraly) > sum(zapas_domaci_vyhraly) as utkani_hoste_vyhraly,
sum(zapas_hoste_vyhraly) = sum(zapas_domaci_vyhraly) as utkani_remiza

from
(
# 1-SUBQUERY
select id_utkani, id_kola, kontumace, id_host, id_domaci,
sum(domaci > hoste) as vysledek_domaci_vyhraly,
sum(hoste > domaci) as vysledek_hoste_vyhraly,
#sum(domaci = hoste) as vysledek_remiza,

sum(hoste > domaci) < sum(domaci > hoste) as zapas_domaci_vyhraly,
sum(hoste > domaci) > sum(domaci > hoste) as zapas_hoste_vyhraly,
sum(hoste > domaci) = sum(domaci > hoste) as zapas_remiza


from vysledky_kolo
join vysledky_utkani using (id_kola)
join vysledky_zapas using (id_utkani)
join vysledky_vysledek using (id_zapasu)

WHERE sezona = 2012
AND poradi <= 3
AND id_souteze = 2

group by id_zapasu
# /1-SUBQUERY
) zapasy

group by id_utkani
# /2-SUBQUERY
) utkani

group by id_domaci
# /1-UNION
) 

UNION

(
# 2-UNION
select id_host as id_domaci, id_kola, utkani_remiza,

sum(utkani_domaci_vyhraly) as utkani_domaci_vyhraly,
sum(utkani_hoste_vyhraly) as utkani_hoste_vyhraly,

sum(IF(utkani_hoste_vyhraly, kontumace, 0)) as kontumace,
sum(zapas_domaci_vyhraly_skore) as domaci_skore,
sum(zapas_hoste_vyhraly_skore) as hoste_skore

from
(
# 2-SUBQUERY
select id_kola, id_utkani, kontumace, id_host, id_domaci,

sum(zapas_domaci_vyhraly) as zapas_domaci_vyhraly_skore,
sum(zapas_hoste_vyhraly) as zapas_hoste_vyhraly_skore,

sum(zapas_hoste_vyhraly) < sum(zapas_domaci_vyhraly) as utkani_domaci_vyhraly,
sum(zapas_hoste_vyhraly) > sum(zapas_domaci_vyhraly) as utkani_hoste_vyhraly,
sum(zapas_hoste_vyhraly) = sum(zapas_domaci_vyhraly) as utkani_remiza

from
(
# 1-SUBQUERY
select id_utkani, id_kola, kontumace, id_host, id_domaci,
sum(domaci > hoste) as vysledek_domaci_vyhraly,
sum(hoste > domaci) as vysledek_hoste_vyhraly,
#sum(domaci = hoste) as vysledek_remiza,

sum(hoste > domaci) < sum(domaci > hoste) as zapas_domaci_vyhraly,
sum(hoste > domaci) > sum(domaci > hoste) as zapas_hoste_vyhraly,
sum(hoste > domaci) = sum(domaci > hoste) as zapas_remiza


from vysledky_kolo
join vysledky_utkani using (id_kola)
join vysledky_zapas using (id_utkani)
join vysledky_vysledek using (id_zapasu)

WHERE sezona = 2012
AND poradi <= 3
AND id_souteze = 2

group by id_zapasu
# /1-SUBQUERY
) zapasy

group by id_utkani
# /2-SUBQUERY
) utkani

group by id_host
# /2-UNION
) 

) AS tabulka
join vysledky_tym on (id_domaci = id_tymu)

#group by id_domaci
















-- by subselect

select id_tymu, nazev, id_kola,

sum(zapas_skore_plus) as skore_plus,
sum(zapas_skore_minus) as skore_minus,

sum(utkani_vyhry) as vyhry,
sum(utkani_remizy) as remizy,
sum(utkani_vyhry)*2 + sum(utkani_remizy) as body

from
(
# 3-SUBQUERY
select *,

#tým
IF(utkani_hoste_vyhraly, id_host, id_domaci) as id_tymu,

#skóre
IF(utkani_hoste_vyhraly, zapas_hoste_vyhraly_skore, zapas_domaci_vyhraly_skore) as zapas_skore_plus,
IF(utkani_hoste_vyhraly, zapas_domaci_vyhraly_skore, zapas_hoste_vyhraly_skore) as zapas_skore_minus,

#vyhry x prohry
IF(utkani_remiza, 0, 1) as utkani_vyhry,
utkani_remiza as utkani_remizy



#sum(utkani_domaci_vyhraly) as utkani_domaci_vyhraly,
#sum(utkani_hoste_vyhraly) as utkani_hoste_vyhraly,

#sum(IF(utkani_hoste_vyhraly, kontumace, 0)) as kontumace,
#sum(zapas_domaci_vyhraly_skore) as domaci_skore,
#sum(zapas_hoste_vyhraly_skore) as hoste_skore

from
(
# 2-SUBQUERY
select id_kola, id_utkani, kontumace, id_domaci, id_host, 

sum(zapas_domaci_vyhraly) as zapas_domaci_vyhraly_skore,
sum(zapas_hoste_vyhraly) as zapas_hoste_vyhraly_skore,

sum(zapas_hoste_vyhraly) < sum(zapas_domaci_vyhraly) as utkani_domaci_vyhraly,
sum(zapas_hoste_vyhraly) > sum(zapas_domaci_vyhraly) as utkani_hoste_vyhraly,
sum(zapas_hoste_vyhraly) = sum(zapas_domaci_vyhraly) as utkani_remiza

from 
(
# 1-SUBQUERY
select id_utkani, id_kola, kontumace, id_domaci, id_host,
sum(domaci > hoste) as vysledek_domaci_vyhraly,
sum(hoste > domaci) as vysledek_hoste_vyhraly,
#sum(domaci = hoste) as vysledek_remiza,

sum(hoste > domaci) < sum(domaci > hoste) as zapas_domaci_vyhraly,
sum(hoste > domaci) > sum(domaci > hoste) as zapas_hoste_vyhraly,
sum(hoste > domaci) = sum(domaci > hoste) as zapas_remiza


from vysledky_kolo
join vysledky_utkani using (id_kola)
join vysledky_zapas using (id_utkani)
join vysledky_vysledek using (id_zapasu)

WHERE sezona = 2012
AND poradi <= 3
AND id_souteze = 2

group by id_zapasu
# /1-SUBQUERY 
) zapasy

group by id_utkani
# /2-SUBQUERY
) utkani
# /3-SUBQUERY
) vyherni

join vysledky_tym using (id_tymu)

group by id_tymu

order by body desc;