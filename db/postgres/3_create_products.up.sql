CREATE TABLE product.products (
  id            SERIAL PRIMARY KEY,
  type_id 	    int NOT NULL,
  name 	        varchar(100) DEFAULT NULL,
  description 	varchar(255) DEFAULT NULL,
  amount 	      FLOAT,
  created_at    TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP
);
ALTER TABLE product.products ADD CONSTRAINT type_id_fkey FOREIGN KEY (type_id) REFERENCES product.types (id);

