-- University Management System Database
-- Create Database
CREATE DATABASE IF NOT EXISTS university_db;
USE university_db;

-- Students Table
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(20) UNIQUE NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    department VARCHAR(50) NOT NULL,
    year_level INT NOT NULL,
    gpa DECIMAL(3,2) NOT NULL,
    address TEXT,
    enrollment_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Teachers Table
CREATE TABLE IF NOT EXISTS teachers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    teacher_id VARCHAR(20) UNIQUE NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    department VARCHAR(50) NOT NULL,
    specialization VARCHAR(100) NOT NULL,
    qualification VARCHAR(100) NOT NULL,
    salary DECIMAL(10,2) NOT NULL,
    hire_date DATE NOT NULL,
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Workers Table
CREATE TABLE IF NOT EXISTS workers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    worker_id VARCHAR(20) UNIQUE NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    position VARCHAR(50) NOT NULL,
    department VARCHAR(50) NOT NULL,
    salary DECIMAL(10,2) NOT NULL,
    hire_date DATE NOT NULL,
    address TEXT,
    national_id VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Admin Table
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin (username: admin, password: admin)
INSERT INTO admins (username, password) VALUES ('admin', 'admin');

-- Insert 10 Students with sample data
INSERT INTO students (student_id, full_name, email, phone, department, year_level, gpa, address, enrollment_date) VALUES
('S001', 'Иван Иванов', 'ivan.ivanov@university.edu', '+7 555-0101', 'Информатика', 2, 3.75, '123 Main St, City', '2023-09-01'),
('S002', 'Анна Петрова', 'anna.p@university.edu', '+7 555-0102', 'Электротехника', 3, 3.92, '456 Oak Ave, City', '2022-09-01'),
('S003', 'Сергей Сидоров', 'sergey.s@university.edu', '+7 555-0103', 'Машиностроение', 1, 3.45, '789 Pine Rd, City', '2024-09-01'),
('S004', 'Мария Кузнецова', 'maria.k@university.edu', '+7 555-0104', 'Информатика', 4, 3.88, '321 Elm St, City', '2021-09-01'),
('S005', 'Дмитрий Попов', 'dmitry.p@university.edu', '+7 555-0105', 'Гражданское строительство', 2, 3.60, '654 Maple Dr, City', '2023-09-01'),
('S006', 'Ольга Смирнова', 'olga.s@university.edu', '+7 555-0106', 'Информационные технологии', 3, 3.95, '987 Cedar Ln, City', '2022-09-01'),
('S007', 'Алексей Волков', 'alexey.v@university.edu', '+7 555-0107', 'Информатика', 1, 3.52, '147 Birch St, City', '2024-09-01'),
('S008', 'Екатерина Соколова', 'ekaterina.s@university.edu', '+7 555-0108', 'Электротехника', 2, 3.78, '258 Spruce Ave, City', '2023-09-01'),
('S009', 'Андрей Михайлов', 'andrey.m@university.edu', '+7 555-0109', 'Машиностроение', 4, 3.85, '369 Ash Rd, City', '2021-09-01'),
('S010', 'Наталья Иванова', 'natalya.i@university.edu', '+7 555-0110', 'Гражданское строительство', 3, 3.70, '741 Willow Dr, City', '2022-09-01');

-- Insert 10 Teachers with sample data
INSERT INTO teachers (teacher_id, full_name, email, phone, department, specialization, qualification, salary, hire_date, address) VALUES
('T001', 'Др. Александр Сергеев', 'a.sergeev@university.edu', '+7 555-0201', 'Информатика', 'Искусственный интеллект', 'Кандидат наук по информатике', 85000.00, '2015-08-15', '100 Faculty St, City'),
('T002', 'Проф. Елена Иванова', 'e.ivanova@university.edu', '+7 555-0202', 'Электротехника', 'Системы электропитания', 'Кандидат наук по электротехнике', 92000.00, '2012-09-01', '200 Professor Ave, City'),
('T003', 'Др. Михаил Петров', 'm.petrov@university.edu', '+7 555-0203', 'Машиностроение', 'Термодинамика', 'Кандидат наук по машиностроению', 88000.00, '2016-01-10', '300 Academic Rd, City'),
('T004', 'Проф. Ольга Сидорова', 'o.sidorova@university.edu', '+7 555-0204', 'Информатика', 'Системы баз данных', 'Кандидат наук по информатике', 90000.00, '2013-07-20', '400 Campus Dr, City'),
('T005', 'Др. Дмитрий Кузнецов', 'd.kuznetsov@university.edu', '+7 555-0205', 'Гражданское строительство', 'Строительная инженерия', 'Кандидат наук по строительству', 87000.00, '2014-03-15', '500 University Ln, City'),
('T006', 'Проф. Анна Попова', 'a.popova@university.edu', '+7 555-0206', 'Информационные технологии', 'Сетевая безопасность', 'Кандидат наук по ИТ', 91000.00, '2011-10-01', '600 Education St, City'),
('T007', 'Др. Сергей Волков', 's.volkov@university.edu', '+7 555-0207', 'Информатика', 'Программная инженерия', 'Кандидат наук по информатике', 89000.00, '2015-05-12', '700 Scholar Ave, City'),
('T008', 'Проф. Мария Смирнова', 'm.smirnova@university.edu', '+7 555-0208', 'Электротехника', 'Системы управления', 'Кандидат наук по электротехнике', 93000.00, '2010-09-05', '800 Learning Rd, City'),
('T009', 'Др. Андрей Михайлов', 'a.mikhailov@university.edu', '+7 555-0209', 'Машиностроение', 'Механика жидкостей', 'Кандидат наук по машиностроению', 86000.00, '2017-02-20', '900 Knowledge Dr, City'),
('T010', 'Проф. Наталья Соколова', 'n.sokolova@university.edu', '+7 555-0210', 'Гражданское строительство', 'Транспортная инженерия', 'Кандидат наук по строительству', 88500.00, '2013-11-15', '1000 Wisdom Ln, City');

-- Insert 10 Workers with sample data
INSERT INTO workers (worker_id, full_name, email, phone, position, department, salary, hire_date, address, national_id) VALUES
('W001', 'Георгий Адамов', 'g.adams@university.edu', '+7 555-0301', 'Специалист по поддержке ИТ', 'Отдел ИТ', 45000.00, '2018-06-01', '1100 Staff St, City', 'N12345678'),
('W002', 'Елена Бейкер', 'h.baker@university.edu', '+7 555-0302', 'Административный помощник', 'Администрация', 38000.00, '2019-03-15', '1200 Employee Ave, City', 'N23456789'),
('W003', 'Франк Нельсон', 'f.nelson@university.edu', '+7 555-0303', 'Лаборант', 'Инженерная лаборатория', 42000.00, '2017-09-10', '1300 Worker Rd, City', 'N34567890'),
('W004', 'Карол Митчелл', 'c.mitchell@university.edu', '+7 555-0304', 'Библиотекарь', 'Библиотека', 40000.00, '2016-11-20', '1400 Service Dr, City', 'N45678901'),
('W005', 'Кевин Робертс', 'k.roberts@university.edu', '+7 555-0305', 'Руководитель обслуживания', 'Хозяйственный отдел', 48000.00, '2015-07-05', '1500 Support Ln, City', 'N56789012'),
('W006', 'Дороти Тернер', 'd.turner@university.edu', '+7 555-0306', 'Координатор по персоналу', 'Отдел кадров', 44000.00, '2018-02-28', '1600 Operations St, City', 'N67890123'),
('W007', 'Стивен Филлипс', 's.phillips@university.edu', '+7 555-0307', 'Охранник', 'Охрана', 36000.00, '2019-08-12', '1700 Safety Ave, City', 'N78901234'),
('W008', 'Рут Кэмпбелл', 'r.campbell@university.edu', '+7 555-0308', 'Бухгалтер', 'Финансы', 52000.00, '2016-04-18', '1800 Finance Rd, City', 'N89012345'),
('W009', 'Эдвард Паркер', 'e.parker@university.edu', '+7 555-0309', 'Администратор сети', 'Отдел ИТ', 55000.00, '2017-12-01', '1900 Tech Dr, City', 'N90123456'),
('W010', 'Сандра Эванс', 's.evans@university.edu', '+7 555-0310', 'Регистратор', 'Регистратура', 46000.00, '2018-10-25', '2000 Records Ln, City', 'N01234567');
