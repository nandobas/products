CREATE TABLE product.charge_fees (
  id              SERIAL PRIMARY KEY,
  type_id 		    int NOT NULL,
  charge_fee 		  NUMERIC(6, 4) NOT NULL,
  in_place_since 	TIMESTAMP WITH TIME ZONE NOT NULL,
  created_at 		  TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP
);
ALTER TABLE product.charge_fees ADD CONSTRAINT type_id_fkey FOREIGN KEY (type_id) REFERENCES product.types (id);

INSERT into product.charge_fees (type_id, charge_fee, in_place_since) 
VALUES 
  (1, 0.02, '2022-09-01T00:00:01.000Z'),
  (2, 0.03, '2022-09-01T00:00:01.000Z'),
  (3, 0.05, '2022-09-01T00:00:01.000Z'),
  (4, 0.10, '2022-09-01T00:00:01.000Z');
