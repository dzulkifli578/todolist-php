CREATE DATABASE IF NOT EXISTS todolist;

CREATE TABLE `tasks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NOT NULL,
  `priority` enum('high','mid','low') DEFAULT NOT NULL,
  `status` enum('finished','unfinished') DEFAULT NOT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `tasks` (`name`, `priority`, `status`, `date`) VALUES
('Task 1', 'high', 'unfinished', '2025-03-17 10:00:00'),
('Task 2', 'mid', 'finished', '2025-03-16 12:00:00'),
('Task 3', 'low', 'unfinished', '2025-03-15 14:00:00'),
('Task 4', 'high', 'unfinished', '2025-03-14 08:30:00'),
('Task 5', 'mid', 'finished', '2025-03-13 16:45:00'),
('Task 6', 'low', 'unfinished', '2025-03-12 09:20:00'),
('Task 7', 'high', 'finished', '2025-03-11 11:10:00'),
('Task 8', 'mid', 'unfinished', '2025-03-10 17:00:00'),
('Task 9', 'low', 'finished', '2025-03-09 13:30:00'),
('Task 10', 'high', 'unfinished', '2025-03-08 15:00:00');