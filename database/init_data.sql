INSERT INTO library(id, name) VALUES 
(0, "ubuntu"),
(1, "update"),
(2, "python"),
(3, "workdir"),
(4, "cmd");

INSERT INTO command(docker_instructor, cmd, library_id) VALUES ("FROM", "ubuntu:latest", 0),
                ("RUN", "apt-get update -y", 1),
                ("RUN", "apt-get install -y python3-dev python3-pip", 2),
                ("RUN", "mkdir /home/user", 3),
                ("WORKDIR", "/home/user/", 3),
                ("CMD", "tail -f /dev/null", 4)