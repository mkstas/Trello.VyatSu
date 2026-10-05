CREATE TABLE demo (
    id serial PRIMARY KEY,
    created_at timestamptz NOT NULL DEFAULT now(),
    note text
);

INSERT INTO demo (note) VALUES ('Hello from initdb!');
