INSERT INTO project (name, user_id) 
VALUES 
("Входящие", 2), ("Авто", 1), ("Домашние дела", 2), ("Работа", 1), ("Учеба", 1);

INSERT INTO users (date_reg, name, email, pass)
VALUES 
("2019-01-02", "Константин", "costya@mail.ru", "$2y$10$qgn08C.3..MuJCDAjxoIo.YlXaWCMcLiNk0v3wo5F0KIATeC9DDJG"),
("2019-06-02", "Пётр", "petya@mail.ru", "$2y$10$qgn08C.3..MuJCDAjxoIo.YlXaWCMcLiNk0v3wo5F0KIATeC9DDJG");

INSERT INTO tasks (date_create, date_exec, status, name, file, deadline, project_id, user_id) 
VALUES
("2019-06-02", "2019-12-01", "0", "Собеседование в IT компании", "Lighthouse.jpg", "2019-11-21 09:00:00", 4, 1),
("2019-06-02", "2019-12-25", "0", "Выполнить тестовое задание", "Lighthouse.jpg", "2019-12-23 09:00:00", 4, 1),
("2019-06-02", "2019-12-21", "1", "Сделать задание первого раздела", "Lighthouse.jpg", "2019-12-19 09:00:00", 5, 1),
("2019-06-02", "2019-12-22", "0", "Встреча с другом", "Lighthouse.jpg", "2019-12-22 09:00:00", 1, 2),
("2019-06-02", "2019-12-22", "0", "Купить корм для кота", "Lighthouse.jpg", "2019-12-22 09:00:00", 3, 2),
("2019-06-02", "2019-12-22", "0", "Заказать пиццу", "Lighthouse.jpg", "2019-12-22 09:00:00", 3, 2);

