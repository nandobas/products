CREATE TABLE product.charge_fees (
  id              SERIAL PRIMARY KEY,
  type_id 		    int NOT NULL,
  charge_fee 		  NUMERIC(6, 4) NOT NULL,
  in_place_since 	TIMESTAMP WITH TIME ZONE NOT NULL,
  created_at 		  TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP
);
ALTER TABLE product.charge_fees ADD CONSTRAINT type_id_fkey FOREIGN KEY (type_id) REFERENCES product.types (id);

