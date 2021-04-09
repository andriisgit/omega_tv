# omega_tv
## Тестовое задание для вакансии php-разработчик

Имеются компании (company), которые могут иметь несколько своих тв-тарифов (tariff). К каждой компании могут подключаются клиенты (customer) на выбранные тарифы (можно несколько). Компании могут так же временно отключать клиентов.

1. Написать структуру таблиц MySQL для хранения этих данных.

2. Написать SQL-запросы для получения:

    1. Количество всех клиентов, подписанных хоть на один тариф (по компаниям)
    2. Количество неактивных клиентов, подписанных на тарифы (по компаниям)
    3. Список тарифов и количество активных клиентов подписанных на эти тарифы (по компаниям)
  4. Список активных клиентов и тарифы, на которые они подписаны

3. Написать консольный php-скрипт для формирования отчетов компаний в разных форматах. В результате работы скрипта должен быть получен набор файлов с названием <company-name>-<report-date>.<file_type>

Внутри каждого файла:
  • будет название компании, дата формирования отчета
  • результаты запросов из п. 2 

4. Форматы файлов:
    1. XML
    2. CSV
    3. JSON
    4. Excel

При написании скрипта можно использовать любой фреймворк.

### Структура БД из пяти таблиц:
* company
* customer
* tarif
* company_customer_tarif
* tarif_active

Дамп таблиц в каталоге `db`

### SQL-запросы:
```sql
# Количество всех клиентов, подписанных хоть на один тариф (по компаниям)
SELECT `co`.`name` AS `Компания`, COUNT(`co`.`id`) AS `Кол-во всех клиентов`, NOW() AS `дата формирования отчета`
FROM `company` AS `co`
RIGHT JOIN `company_customer_tarif` AS `cct` ON `cct`.`company_id` = `co`.`id`
LEFT JOIN `customer` AS `cu` ON `cu`.`id` = `cct`.`customer_id`
GROUP BY `co`.`id`
ORDER BY `co`.`name`

# Количество неактивных клиентов, подписанных на тарифы (по компаниям)
SELECT `co`.`name` AS `Компания`, COUNT(`co`.`id`) AS `Кол-во неактивных клиентов`, NOW() AS `дата формирования отчета`
FROM `company` AS `co`
RIGHT JOIN `company_customer_tarif` AS `cct` ON `cct`.`company_id` = `co`.`id`
LEFT JOIN `customer` AS `cu` ON `cu`.`id` = `cct`.`customer_id`
RIGHT JOIN `tarif_active` AS `a` ON `a`.`cct_id` = `cct`.`id`
WHERE `a`.`is_active` = 0 OR `a`.`date_end` < NOW()
GROUP BY `co`.`id`
ORDER BY `co`.`name`

# Список тарифов и количество активных клиентов подписанных на эти тарифы (по компаниям)
SELECT `co`.`name` AS `Компания`, `t`.`name` AS `тариф`, COUNT(`a`.`id`) AS `Кол-во активных клиентов`, NOW() AS `дата формирования отчета`
FROM `tarif` AS `t`
LEFT JOIN `company_customer_tarif` AS `cct` ON `cct`.`tarif_id` = `t`.`id`
LEFT JOIN `company` AS `co` ON `co`.`id` = `cct`.`company_id`
LEFT JOIN `tarif_active` AS `a` ON `a`.`cct_id` = `cct`.`id`
WHERE `a`.`is_active` = 1 AND `a`.`date_end` >= NOW()
GROUP BY `a`.`id`
ORDER BY `co`.`name`

# Список активных клиентов и тарифы, на которые они подписаны
SELECT `cu`.`name` AS `Клиент`, `t`.`name` AS `тариф`, `a`.`date_end` AS `Дата окончания тарифа`, NOW() AS `дата формирования отчета`
FROM `tarif` AS `t`
LEFT JOIN `company_customer_tarif` AS `cct` ON `cct`.`tarif_id` = `t`.`id`
LEFT JOIN `customer` AS `cu` ON `cu`.`id` = `cct`.`customer_id`
LEFT JOIN `tarif_active` AS `a` ON `a`.`cct_id` = `cct`.`id`
WHERE `a`.`is_active` = 1 AND `a`.`date_end` >= NOW()
ORDER BY `cu`.`name`, `t`.`name`
```
### консольный php-скрипт:
`index.php`

### пример выгруженных отчетов №1 и №3 в каталоге `reports`

