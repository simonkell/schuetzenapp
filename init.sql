CREATE TABLE IF NOT EXISTS `users` 
(  
    `id` int NOT NULL AUTO_INCREMENT,  
    `username` varchar(50) NOT NULL,  
    `emailid` varchar(50) NOT NULL,  
    `password` varchar(150) NOT NULL,
    `isadmin` int NOT NULL,  
    PRIMARY KEY (`id`)  
);
CREATE TABLE IF NOT EXISTS `strafen` 
(  
    `id` int NOT NULL AUTO_INCREMENT,  
    `userid` int(11) NOT NULL,  
    `text` varchar(250) NOT NULL,  
    `time` int NOT NULL,
    `amount` int NOT NULL,  
    PRIMARY KEY (`id`)  
);
INSERT INTO users(username, emailid, password, isadmin) values('Administrator','test@test.xyz','413acdf5f0d7500c72fe6082a4b7aa499aa5c2bea60c7e514854932372123261b923dde192269978ede73d69984c1076e8c92093eb79bfd63b6d189a07d72dec','1');