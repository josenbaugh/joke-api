CREATE DATABASE IF NOT EXISTS dev;
CREATE DATABASE IF NOT EXISTS test;
USE dev;

drop table if exists ApiConfiguration;
create table ApiConfiguration(
   id INT NOT NULL AUTO_INCREMENT,
   Type VARCHAR(15) NOT NULL,
   Name VARCHAR(15) NOT NULL,
   Value VARCHAR(10) NOT NULL,
   PRIMARY KEY ( id )
);
insert into ApiConfiguration (Type, Name, Value)
values
('blacklist', 'nsfw', 'false'),
('blacklist', 'religious', 'false'),
('blacklist', 'political', 'false'),
('blacklist', 'racist', 'false'),
('blacklist', 'sexist', 'false'),
('blacklist', 'explicit', 'false'), 
('joketype', 'single', 'true'),
('joketype', 'double', 'true');
