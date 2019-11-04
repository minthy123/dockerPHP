INSERT INTO library(id, name) VALUES 
(0, "ubuntu"),
(1, "update"),
(2, "python"),
(3, "workdir"),
(4, "cmd"),
(5, "tensor"),
(6, "jupyter");

INSERT INTO command(docker_instructor, cmd, library_id) VALUES 
                ("FROM", "ubuntu:latest", 0),
                ("RUN", "apt-get update -y", 1),
                ("RUN", "apt-get install -y python3-dev python3-pip", 2),
                ("RUN", "mkdir /home/user", 3),
                ("WORKDIR", "/home/user/", 3),
                ("CMD", "tail -f /dev/null", 4),
                ("RUN", "pip3 install --user --upgrade tensorflow", 5),
                ("RUN", "pip3 install jupyter", 6);

INSERT INTO dependence(library_id, parent_library_id) VALUES
(1,0),
(2,1),
(5,2),
(6,2);