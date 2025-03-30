-- Users Table
CREATE TABLE Users (
    user_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL UNIQUE,
    email VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, -- Store hashed passwords
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO Users (username, email, password) VALUES 
('john_doe', 'john@example.com', 'hashedpassword123'),
('alice_smith', 'alice@example.com', 'hashedpassword456');

-- User Profiles Table
CREATE TABLE User_Profiles (
    profile_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    profile_background VARCHAR(255),
    profile_cover VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE
);

INSERT INTO User_Profiles (user_id, profile_background, profile_cover) VALUES 
(1, 'blue_gradient.jpg', 'cover1.jpg'),
(2, 'dark_theme.jpg', 'cover2.jpg');

-- Projects Table
CREATE TABLE Projects (
    project_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    project_name VARCHAR(100) NOT NULL,
    project_description TEXT NOT NULL,
    project_status ENUM('Pending', 'Ongoing', 'Completed', 'Archived') NOT NULL,
    created_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES Users(user_id) ON DELETE CASCADE
);

INSERT INTO Projects (project_name, project_description, project_status, created_by) VALUES 
('Task Management System', 'A system to manage tasks efficiently.', 'Ongoing', 1),
('E-Commerce Platform', 'A platform for online shopping.', 'Pending', 2);

-- Tasks Table
CREATE TABLE Tasks (
    task_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    task_name VARCHAR(100) NOT NULL,
    task_description TEXT NOT NULL,
    task_status ENUM('Pending', 'In Progress', 'Completed') NOT NULL,
    due_date DATE NOT NULL,
    project_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES Projects(project_id) ON DELETE CASCADE
);

INSERT INTO Tasks (task_name, task_description, task_status, due_date, project_id) VALUES 
('Design UI', 'Create UI for the Task Management App.', 'In Progress', '2025-04-15', 1),
('Setup Database', 'Design database schema for e-commerce.', 'Pending', '2025-05-01', 2);

-- Task Attachments Table
CREATE TABLE Task_Attachments (
    attachment_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    task_id INT NOT NULL,
    user_id INT NOT NULL,
    attachment_name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (task_id) REFERENCES Tasks(task_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE
);

INSERT INTO Task_Attachments (task_id, user_id, attachment_name) VALUES 
(1, 1, 'ui_mockup.png'),
(2, 2, 'database_schema.sql');

-- Task Suggestions Table
CREATE TABLE Task_Suggestions (
    suggestion_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    task_id INT NOT NULL,
    suggestion_text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (task_id) REFERENCES Tasks(task_id) ON DELETE CASCADE
);

INSERT INTO Task_Suggestions (task_id, suggestion_text) VALUES 
(1, 'Consider using Tailwind CSS for faster styling.'),
(2, 'Use PostgreSQL instead of MySQL for scalability.');

-- Auth Table
CREATE TABLE Auth (
    role_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    user_token VARCHAR(255) NOT NULL UNIQUE,
    user_authentication BOOLEAN NOT NULL DEFAULT FALSE,
    user_authorization ENUM('Admin', 'User', 'Manager') NOT NULL,
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE
);

INSERT INTO Auth (user_id, user_token, user_authentication, user_authorization) VALUES 
(1, 'token12345xyz', TRUE, 'Admin'),
(2, 'token67890abc', FALSE, 'User');

-- Task History Table
CREATE TABLE History (
    history_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    task_id INT NOT NULL,
    old_task_status ENUM('Pending', 'In Progress', 'Completed') NOT NULL,
    new_task_status ENUM('Pending', 'In Progress', 'Completed') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (task_id) REFERENCES Tasks(task_id) ON DELETE CASCADE
);

INSERT INTO History (task_id, old_task_status, new_task_status) VALUES 
(1, 'Pending', 'In Progress'),
(2, 'Pending', 'Pending');
