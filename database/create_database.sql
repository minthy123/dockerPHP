CREATE TABLE IF NOT EXISTS library (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL UNIQUE,
    isGPU BOOLEAN NOT NULL
);

CREATE TABLE IF NOT EXISTS command (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    docker_instructor TEXT NOT NULL,
    cmd TEXT NOT NULL,
    library_id INTEGER NOT NULL,
    FOREIGN KEY(library_id) REFERENCES library(id)
);

CREATE TABLE IF NOT EXISTS dependence (
    library_id INTEGER NOT NULL,
    parent_library_id INTEGER NOT NULL
);

CREATE TABLE IF NOT EXISTS user (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL,
    password TEXT NOT NULL
)