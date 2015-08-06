add -> fk_id für archive
update schema für sende_files
add new tables


UPDATE archive_files af 
INNER JOIN file_index fi ON fi.fk_id = af.id
SET af.fk_id = fi.id