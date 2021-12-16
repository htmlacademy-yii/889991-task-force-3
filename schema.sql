DROP DATABASE IF EXISTS taskforce;
CREATE DATABASE taskforce CHARACTER SET = utf8;
USE taskforce;

CREATE TABLE cities (
  id INT AUTO_INCREMENT PRIMARY KEY,
  city_name VARCHAR(255)
);
CREATE TABLE roles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  role_name VARCHAR(128)
);
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  date_registration DATETIME DEFAULT CURRENT_TIMESTAMP,
  user_name VARCHAR(128),
  email VARCHAR(128) NOT NULL UNIQUE,
  city_id INT,
  user_password CHAR(255),
  role_id INT,
  FOREIGN KEY (city_id) REFERENCES cities(id),
  FOREIGN KEY (role_id) REFERENCES roles(id)
);
CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  character_code VARCHAR(128) UNIQUE,
  category_name VARCHAR(128)
);
CREATE TABLE tasks (
  id INT AUTO_INCREMENT PRIMARY KEY,
  date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
  title VARCHAR(255),
  task_description TEXT,
  budget INT,
  period_execution DATE,
  city_id INT,
  task_location VARCHAR(255),
  user_id INT,
  executor_id INT,
  category_id INT,
  task_status VARCHAR(128),
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (category_id) REFERENCES categories(id),
  FOREIGN KEY (city_id) REFERENCES cities(id)
);
CREATE TABLE files (
  id INT AUTO_INCREMENT PRIMARY KEY,
  task_id INT,
  file_path VARCHAR(255),
  FOREIGN KEY (task_id) REFERENCES tasks(id)
);
CREATE TABLE executors (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  avatar VARCHAR(255),
  birthday DATE,
  phone VARCHAR(128),
  telegram VARCHAR(128),
  profile_info TEXT,
  current_status VARCHAR(128),
  count_compleded_tasks INT,
  count_failed_tasks INT,
  sum_ratings INT,
  specializations VARCHAR(255),
  FOREIGN KEY (user_id) REFERENCES users(id)
);
CREATE TABLE response (
  id INT AUTO_INCREMENT PRIMARY KEY,
  task_id INT,
  executor_id INT,
  prise INT,
  coment TEXT,
  FOREIGN KEY (task_id) REFERENCES tasks(id),
  FOREIGN KEY (executor_id) REFERENCES executors(id)
);
CREATE TABLE reviews (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  task_id INT,
  executor_id INT,
  coment TEXT,
  rating INT,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (task_id) REFERENCES tasks(id),
  FOREIGN KEY (executor_id) REFERENCES executors(id)
);
