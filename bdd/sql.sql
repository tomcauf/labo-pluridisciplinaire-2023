CREATE TABLE `User` (
                        `id_user` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
                        `firstname` varchar(150) NOT NULL,
                        `name` varchar(150) NOT NULL,
                        `email` varchar(255) UNIQUE NOT NULL,
                        `password` varchar(255) NOT NULL,
                        `manager` int(11),
                        `active` bool NOT NULL
);

CREATE TABLE `Have` (
                        `id_user` int(11) NOT NULL,
                        `id_function` int(11) NOT NULL
);

CREATE TABLE `Function` (
                            `id_function` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
                            `name` varchar(255) NOT NULL,
                            `role_level` int(11) NOT NULL
);

CREATE TABLE `Training` (
                            `id_training` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
                            `name` varchar(255) NOT NULL,
                            `description` varchar(255),
                            `location` varchar(255) NOT NULL,
                            `duration` time NOT NULL,
                            `deadline` date NOT NULL,
                            `active` bool NOT NULL,
                            `certificate_deadline` date NOT NULL
);

CREATE TABLE `Trainer` (
                           `id_user` int(11) NOT NULL,
                           `id_training` int(11) NOT NULL
);

CREATE TABLE `Operate` (
                           `id_function` int(11) NOT NULL,
                           `id_training` int(11) NOT NULL
);

CREATE TABLE `Participate` (
                               `id_participation` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
                               `id_user` int(11) NOT NULL,
                               `id_training` int(11) NOT NULL,
                               `status` SET('ON HOLD', 'IN PROGRESS','DONE','SENT', 'VALIDATED') NOT NULL,
                               `file_link` varchar(500)
);

CREATE TABLE `Request` (
                           `id_request` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
                           `validation_type` SET('ACCESSED', 'VALIDATED'),
                           `id_validator` int(11) NOT NULL,
                           `validation_date` date NOT NULL
);

CREATE TABLE `RequiredTraining` (
                                    `id_training` int(11) NOT NULL,
                                    `required_ID` int(11) NOT NULL
);

CREATE TABLE `Accreditation` (
                                 `id_accreditation` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
                                 `name` varchar(150)
);

CREATE TABLE `GiveAccess` (
                              `id_accreditation` int(11) NOT NULL,
                              `id_training` int(11) NOT NULL
);

ALTER TABLE `User` ADD FOREIGN KEY (`manager`) REFERENCES `User` (`id_user`);

ALTER TABLE `Have` ADD FOREIGN KEY (`id_user`) REFERENCES `User` (`id_user`);

ALTER TABLE `Trainer` ADD FOREIGN KEY (`id_user`) REFERENCES `User` (`id_user`);

ALTER TABLE `Have` ADD FOREIGN KEY (`id_function`) REFERENCES `Function` (`id_function`);

ALTER TABLE `Operate` ADD FOREIGN KEY (`id_function`) REFERENCES `Function` (`id_function`);

ALTER TABLE `Operate` ADD FOREIGN KEY (`id_training`) REFERENCES `Training` (`id_training`);

ALTER TABLE `Trainer` ADD FOREIGN KEY (`id_training`) REFERENCES `Training` (`id_training`);

ALTER TABLE `Participate` ADD FOREIGN KEY (`id_user`) REFERENCES `User` (`id_user`);

ALTER TABLE `Request` ADD FOREIGN KEY (`id_validator`) REFERENCES `User` (`id_user`);

ALTER TABLE `Request` ADD FOREIGN KEY (`id_request`) REFERENCES `Participate` (`id_participation`);

ALTER TABLE `Participate` ADD FOREIGN KEY (`id_training`) REFERENCES `Training` (`id_training`);

ALTER TABLE `RequiredTraining` ADD FOREIGN KEY (`id_training`) REFERENCES `Training` (`id_training`);

ALTER TABLE `RequiredTraining` ADD FOREIGN KEY (`required_ID`) REFERENCES `Training` (`id_training`);

ALTER TABLE `GiveAccess` ADD FOREIGN KEY (`id_accreditation`) REFERENCES `Accreditation` (`id_accreditation`);

ALTER TABLE `GiveAccess` ADD FOREIGN KEY (`id_training`) REFERENCES `Training` (`id_training`);
