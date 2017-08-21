SELECT
  items.id as 'source_id',
  'j25_k2_items' as 'source_table',
  items.title as 'title_pl',
  translation.title as 'title_en',
  items.alias as 'alias',
  translation.alias as 'alias_en',
  items.introtext as 'into_text',
  translation.introtext as 'into_text_en',
  items.fulltext as 'full_text',
  translation.fulltext as 'full_text_en',
  items.extra_fields as 'attributes',
  items.created,
  items.created_by,
  items.modified,
  items.modified_by,
  items.hits as 'hits_pl',
  translation.hits as 'hits_en'
FROM
  `j25_k2_items` as items
left join `j25_k2_items` as translation on items.id = translation.id - 300
WHERE
  items.catid = 19
and items.published = 1
