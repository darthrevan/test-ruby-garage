SELECT DISTINCT status FROM tasks ORDER BY status;

SELECT projects.id, projects.name, COUNT(tasks.project_id) 
FROM projects 
LEFT JOIN tasks ON projects.id = tasks.project_id 
GROUP BY projects.id 
ORDER BY COUNT(tasks.project_id) DESC;

SELECT projects.id, projects.name, COUNT(tasks.project_id) 
FROM projects 
LEFT JOIN tasks ON projects.id = tasks.project_id 
GROUP BY projects.id 
ORDER BY projects.name;

SELECT tasks.id, tasks.name 
FROM projects, tasks 
WHERE (projects.name LIKE "N%") 
AND tasks.project_id = projects.id;

SELECT id, name 
FROM tasks 
GROUP BY name 
HAVING (COUNT(name) > 1) 
ORDER BY name;

SELECT projects.id, projects.name, COUNT(tasks.project_id) 
FROM projects, tasks 
WHERE projects.id = (tasks.project_id) 
AND tasks.status = "completed" 
GROUP BY projects.id 
HAVING COUNT(tasks.project_id) > 10 
ORDER BY projects.id;
