CREATE TABLE product.products (
  id            SERIAL PRIMARY KEY,
  type_id 	    int NOT NULL,
  name 	        varchar(100) DEFAULT NULL,
  description 	varchar(255) DEFAULT NULL,
  amount 	      FLOAT,
  created_at    TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP
);
ALTER TABLE product.products ADD CONSTRAINT type_id_fkey FOREIGN KEY (type_id) REFERENCES product.types (id);

INSERT into product.products (type_id, name, description, amount) 
VALUES 
  (1, 'Coca-Cola', 'Refrigerante',8.55), 
  (1, 'Fanta', 'Refrigerante',6.75), 
  (2, 'Caesar Salad', 'Salada com alface e crocantes',12.3), 
  (3, 'Carne Grelhada', 'Carne tipo grelhada no fogo',15.9), 
  (3, 'Frango Grelhado', 'Carne tipo ave',14.9), 
  (4, 'Milk', 'Checolate ao leite',10.55);

