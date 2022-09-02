CREATE SCHEMA product;
CREATE table product.types (
  id            SERIAL PRIMARY KEY,
  description   VARCHAR ( 100 ) NOT NULL
);

INSERT into product.types (description) VALUES ('bebida'), ('salada'), ('carne'), ('chocolate');
