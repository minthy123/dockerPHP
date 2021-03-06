INSERT INTO library(id, name, isGPU) VALUES 
(0, "ubuntu", 0),
(2, "python", 0),
(5, "tensor", 0),
(6, "jupyter", 0),
(7, "tensorflow-GPU-1.12", 1),
(8, "keras", 1),
(9, "ubuntu-GPU-cuda-9", 1),
(10, "git", 1),
(11, "centos", 0),
(12, "python centos", 0),
(13, "ubuntu-GPU-cuda-10", 1),
(14, "tensorflow-GPU-latest", 1),
(15, "python-1", 0),
(16, "numpy", 0),
(17, "skirt-learn", 0);

INSERT INTO command(docker_instructor, cmd, library_id) VALUES 
                ("FROM", "ubuntu:latest", 0),
                ("RUN", "apt-get pdate -y", 0),
                ("RUN", "apt-get install -y python3-dev python3-pip", 2),
                ("RUN", "pip3 install --user --upgrade tensorflow", 5),
                ("RUN", "pip3 install jupyter", 6),
                ("EXPOSE", "8080", 6),
                ("CMD", "jupyter notebook --ip 0.0.0.0 --no-browser --allow-root", 6),
                ("RUN", "pip3 install tensorflow-gpu===1.12", 7),
                ("RUN", "pip install keras", 8),
                ("FROM", "nvidia/cuda:9.0-cudnn7-devel", 9),
                ("RUN", "apt-get install -y git", 10),
                ("FROM", "centos:latest", 11),
                ("RUN", "yum update -y", 11),
                ("RUN", "yum install -y python3", 12),
                ("RUN", "apt-get update -y", 9),
                ("FROM", "nvidia/cuda:10.1-devel-ubuntu18.04", 13),
                ("RUN", "apt-get update -y", 13),
                ("RUN", "pip3 install tensorflow-gpu", 14),
                ("RUN", "apt-get install -y python3-dev python3-pip", 15),
                ("RUN", "apt-get install -y python3-numpy", 16),
                ("RUN", "apt-get install -y python3-scipy", 17);

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
(8, 12),
(5,12),
(15, 13),
(14, 15),
(6, 15),
(10, 13),
(16, 2),
(17, 2);

INSERT INTO user(username, password) VALUES
("admin", "21232f297a57a5a743894a0e4a801fc3");

INSERT INTO host(name, ip, port) VALUES
("localhost","172.17.0.1", 2375);