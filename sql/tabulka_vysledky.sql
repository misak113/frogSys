set @sezona = 2012;
set @poradi = 13;
set @soutez = 2;

-- by union

select id_domaci as id_tymu, nazev, web, link, group_concat(utkani_vyhral_nad_tymy) as utkani_vyhral_nad_tymy,

			 sum(utkani_domaci_vyhraly) + sum(utkani_remiza) + sum(utkani_hoste_vyhraly) as zapasy,
			 sum(utkani_domaci_vyhraly) as vyhry,
			 sum(utkani_remiza) as remizy,
			 sum(utkani_hoste_vyhraly) as prohry,
			 sum(kontumace) as kontumace,

			 sum(domaci_skore) as skore_plus,
			 sum(hoste_skore) as skore_minus,
			 sum(domaci_skore) - sum(hoste_skore) as skore_rozdil,

			 sum(utkani_domaci_vyhraly)*2 + sum(utkani_remiza) - sum(kontumace) as body


from (

				 (
# 1-UNION
select id_domaci, id_kola,

		sum(utkani_remiza) as utkani_remiza,
		sum(utkani_domaci_vyhraly) as utkani_domaci_vyhraly,
		sum(utkani_hoste_vyhraly) as utkani_hoste_vyhraly,

		sum(utkani_hoste_vyhraly*kontumace) as kontumace,
		sum(zapas_domaci_vyhraly_skore) as domaci_skore,
		sum(zapas_hoste_vyhraly_skore) as hoste_skore,

		group_concat(IF(utkani_domaci_vyhraly, id_host, 0)) as utkani_vyhral_nad_tymy

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

WHERE sezona = @sezona
			AND poradi <= @poradi
			AND id_souteze = @soutez

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
select id_host as id_domaci, id_kola,

			 sum(utkani_remiza) as utkani_remiza,
			 sum(utkani_domaci_vyhraly) as utkani_domaci_vyhraly,
			 sum(utkani_hoste_vyhraly) as utkani_hoste_vyhraly,

			 sum(utkani_hoste_vyhraly*kontumace) as kontumace,
			 sum(zapas_domaci_vyhraly_skore) as domaci_skore,
			 sum(zapas_hoste_vyhraly_skore) as hoste_skore,

			 group_concat(IF(utkani_domaci_vyhraly, id_domaci, 0)) as utkani_vyhral_nad_tymy

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
		sum(domaci < hoste) as vysledek_domaci_vyhraly,
		sum(hoste < domaci) as vysledek_hoste_vyhraly,
#sum(domaci = hoste) as vysledek_remiza,

		sum(hoste > domaci) > sum(domaci > hoste) as zapas_domaci_vyhraly,
		sum(hoste > domaci) < sum(domaci > hoste) as zapas_hoste_vyhraly,
		sum(hoste > domaci) = sum(domaci > hoste) as zapas_remiza


from vysledky_kolo
		join vysledky_utkani using (id_kola)
		join vysledky_zapas using (id_utkani)
		join vysledky_vysledek using (id_zapasu)

WHERE sezona = @sezona
			AND poradi <= @poradi
			AND id_souteze = @soutez

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

group by id_domaci

order by body desc, zapasy, skore_rozdil desc, skore_plus desc