INSERT INTO library(id, name, isGPU) VALUES 
(0, "ubuntu", false),
(2, "python", false),
(3, "workdir", false),
(4, "cmd", false),
(5, "tensor", false),
(6, "jupyter", false),
(7, "tensorflow-GPU", true),
(8, "keras", true),
(9, "ubuntu-GPU", true),
(10, "git", true),
(11, "centos", false)
(12, "python centos", false);

INSERT INTO command(docker_instructor, cmd, library_id) VALUES 
                ("FROM", "ubuntu:latest", 0),
                ("RUN", "apt-get update -y", 0),
                ("RUN", "apt-get install -y python3-dev python3-pip", 2),
                ("RUN", "mkdir /home/user", 3),
                ("WORKDIR", "/home/user/", 3),
                ("CMD", "tail -f /dev/null", 4),
                ("RUN", "pip3 install --user --upgrade tensorflow", 5),
                ("RUN", "pip3 install jupyter", 6),
                ("RUN", "pip3 install tensorflow-gpu", 7),
                ("RUN", "pip install keras", 8),
                ("FROM", "nvidia/cuda:9.0-cudnn7-devel", 9),
                ("RUN", "apt-get install -y git", 10),
                ("FROM", "centos:latest", 11),
                ("RUN", "yum update -y", 11),
                ("RUN", "yum install -y python3", 12);

INSERT INTO dependence(library_id, parent_library_id) VALUES
(2,0),
(5,2),
(6,2),
(7,2),
(8,2),
(2,9),
(10, 0),
(12, 11),
(6, 12),
(7, 12),
(8, 12);