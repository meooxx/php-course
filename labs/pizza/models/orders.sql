
CREATE TABLE IF NOT EXISTS orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(180) NOT NULL,
  phone VARCHAR(40) NOT NULL,
  product_id INT NOT NULL,
  user_id INT NOT NULL,
  size ENUM('small', 'medium', 'large') NOT NULL DEFAULT 'medium',
  crust ENUM('hand_tossed', 'handmade_pan') NOT NULL DEFAULT 'hand_tossed',
  quantity INT NOT NULL DEFAULT 1,
  fulfillment ENUM('delivery', 'carryout') NOT NULL DEFAULT 'carryout',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_orders_product
    FOREIGN KEY (product_id) REFERENCES products (id)
    ON DELETE RESTRICT ON UPDATE CASCADE
  CONSTRAINT fk_orders_user
    FOREIGN KEY (user_id) REFERENCES pizza_users (id)
    ON DELETE set Null ON UPDATE CASCADE

) DEFAULT CHARSET=utf8mb4;
