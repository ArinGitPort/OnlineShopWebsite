-- 1) Create and use the database
CREATE DATABASE IF NOT EXISTS bunniwinkle8;
USE bunniwinkle8;

-- 2) Lookup / reference tables

CREATE TABLE user_role (
  role_id INT AUTO_INCREMENT PRIMARY KEY,
  role_name VARCHAR(50) NOT NULL
);

CREATE TABLE status (
  status_id INT AUTO_INCREMENT PRIMARY KEY,
  status_name VARCHAR(50) NOT NULL
);

CREATE TABLE verified_status (
  verified_id INT AUTO_INCREMENT PRIMARY KEY,
  verified_name VARCHAR(50) NOT NULL
);

CREATE TABLE item_category (
  category_id INT AUTO_INCREMENT PRIMARY KEY,
  category_name VARCHAR(50) NOT NULL
);

CREATE TABLE item_status (
  item_status_id INT AUTO_INCREMENT PRIMARY KEY,
  item_status_name VARCHAR(50) NOT NULL
);

CREATE TABLE transaction_type (
  trans_type_id INT AUTO_INCREMENT PRIMARY KEY,
  trans_type_name VARCHAR(50) NOT NULL
);

CREATE TABLE transaction_mode (
  trans_mode_id INT AUTO_INCREMENT PRIMARY KEY,
  trans_mode_name VARCHAR(50) NOT NULL
);

CREATE TABLE order_status (
  order_status_id INT AUTO_INCREMENT PRIMARY KEY,
  order_status_name VARCHAR(50) NOT NULL
);

-- Optional tables to manage role-based permissions:
-- (You can omit these if you’re not ready for detailed permission management.)

CREATE TABLE permissions (
  permission_id INT AUTO_INCREMENT PRIMARY KEY,
  permission_name VARCHAR(100) NOT NULL
);

CREATE TABLE role_permissions (
  role_permission_id INT AUTO_INCREMENT PRIMARY KEY,
  role_id INT NOT NULL,
  permission_id INT NOT NULL,
  FOREIGN KEY (role_id) REFERENCES user_role(role_id),
  FOREIGN KEY (permission_id) REFERENCES permissions(permission_id)
);

-- 3) Insert default records in reference tables

INSERT INTO user_role (role_name)
VALUES
 ('Owner/Admin'),  -- 1
 ('Staff'),        -- 2
 ('Brand Partner'),-- 3
 ('Customer');     -- 4

INSERT INTO status (status_name)
VALUES
 ('Active'),   -- 1
 ('Inactive'); -- 2

INSERT INTO verified_status (verified_name)
VALUES
 ('Verified'),     -- 1
 ('Not Verified'); -- 2

INSERT INTO item_category (category_name)
VALUES
 ('Bunniwinkle'),     -- 1
 ('Artaftercoffee'),  -- 2
 ('ARTLIYAAAAH'),     -- 3
 ('AMAZEBALL CRAFT'), -- 4
 ('Bunni'),           -- 5
 ('DREAMERS CREATES');-- 6

INSERT INTO item_status (item_status_name)
VALUES
 ('Available'),       -- 1
 ('Not Available');   -- 2

INSERT INTO transaction_type (trans_type_name)
VALUES
 ('Walk-in'), -- 1
 ('Online');  -- 2

INSERT INTO transaction_mode (trans_mode_name)
VALUES
 ('Cash'),     -- 1
 ('PayMongo'), -- 2
 ('GCash');    -- 3

INSERT INTO order_status (order_status_name)
VALUES
 ('Order Received'),  -- 1
 ('Order Processed'), -- 2
 ('Order Completed'); -- 3

-- (Optional) Insert sample permissions if needed:
INSERT INTO permissions (permission_name)
VALUES
 ('Create Orders'),
 ('View Orders'),
 ('Update Orders'),
 ('Delete Orders'),
 ('Manage Inventory'),
 ('View Reports');

-- (Optional) Assign some permissions to each role
-- For demonstration only:
INSERT INTO role_permissions (role_id, permission_id)
VALUES
 (1, 1), (1, 2), (1, 3), (1, 4), (1, 5), (1, 6), -- Owner/Admin gets everything
 (2, 1), (2, 2), (2, 3), (2, 5),                -- Staff: limited set
 (3, 2),                                        -- Brand Partner: can only view orders in this example
 (4, 2);                                        -- Customer: can only view their own orders (though typically enforced at the app level)

-- 4) Main entity tables

-- 4.1) USERS TABLE (renamed from 'user' to 'users')
-- Use hashed password column rather than plain text. We’ll name it "password_hash".
-- Also add indexes on username and user_email for faster lookups.
CREATE TABLE users(
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    user_role_id INT NOT NULL,
    username VARCHAR(50) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    user_email VARCHAR(250) NOT NULL,
    user_phone VARCHAR(25) NOT NULL,
    user_address VARCHAR(250) NOT NULL,
    user_status_id INT NOT NULL,
    user_verified_id INT NOT NULL DEFAULT 2,
    modified_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_role_id) REFERENCES user_role(role_id),
    FOREIGN KEY (user_status_id) REFERENCES status(status_id),
    FOREIGN KEY (user_verified_id) REFERENCES verified_status(verified_id),
    UNIQUE KEY (username),
    UNIQUE KEY (user_email)
);

-- 4.2) ITEMS TABLE
-- Add a CHECK constraint to ensure stock is never negative.
CREATE TABLE items_inventory(
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(250) NOT NULL,
    item_category_id INT NOT NULL,
    item_description VARCHAR(250) NOT NULL,
    item_price DECIMAL(10,2) NOT NULL,
    item_cost DECIMAL(10,2) NOT NULL,
    item_stock INT NOT NULL,
    item_date DATE NOT NULL,
    price_effective_date DATE NOT NULL,
    price_expiration_date DATE NOT NULL,
    item_status_id INT NOT NULL,
    FOREIGN KEY (item_category_id) REFERENCES item_category(category_id),
    FOREIGN KEY (item_status_id) REFERENCES item_status(item_status_id),
    CHECK (item_stock >= 0)   -- MySQL 8+ enforces this. For older versions, handle in app logic.
);

-- 4.3) ORDERS TABLE
-- Customer references users.user_id; employee references users.user_id.
-- Add an index on order_date to optimize range queries.
CREATE TABLE orders(
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    transaction_type_id INT NOT NULL,
    transaction_mode_id INT NOT NULL,
    customer_id INT NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    discount DECIMAL(10,2) DEFAULT 0.00,
    total_amount DECIMAL(10,2) NOT NULL,
    employee_id INT,
    order_status_id INT NOT NULL,
    FOREIGN KEY (transaction_type_id) REFERENCES transaction_type(trans_type_id),
    FOREIGN KEY (transaction_mode_id) REFERENCES transaction_mode(trans_mode_id),
    FOREIGN KEY (customer_id) REFERENCES users(user_id),
    FOREIGN KEY (employee_id) REFERENCES users(user_id),
    FOREIGN KEY (order_status_id) REFERENCES order_status(order_status_id),
    INDEX (order_date)
);

-- 4.4) ORDER ITEMS TABLE
-- Add a column for item-level discount if needed.
CREATE TABLE order_items(
    order_items_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    item_id INT NOT NULL,
    quantity INT NOT NULL,
    item_discount DECIMAL(10,2) DEFAULT 0.00,  -- if you need per-item discount
    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    FOREIGN KEY (item_id) REFERENCES items_inventory(item_id)
);

-- 4.5) REFUNDS TABLE
-- Now references orders. We'll allow partial refunds in a separate table.
CREATE TABLE refunds(
    refund_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    refunded_amount DECIMAL(10,2),
    refund_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    refund_reason VARCHAR(250) NOT NULL,
    employee_id INT,
    FOREIGN KEY (employee_id) REFERENCES users(user_id),
    FOREIGN KEY (order_id) REFERENCES orders(order_id)
);

-- 4.5a) REFUND ITEMS (for partial refunds at the item level)
CREATE TABLE refund_items(
    refund_item_id INT AUTO_INCREMENT PRIMARY KEY,
    refund_id INT NOT NULL,
    order_items_id INT NOT NULL,
    quantity_refunded INT NOT NULL,
    FOREIGN KEY (refund_id) REFERENCES refunds(refund_id),
    FOREIGN KEY (order_items_id) REFERENCES order_items(order_items_id)
);

-- 4.6) RESTOCK TABLE
-- brand_partner_id references the brand partner’s user_id
CREATE TABLE restock(
    restock_id INT AUTO_INCREMENT PRIMARY KEY,
    shipment_number VARCHAR(250) NOT NULL,
    item_id INT NOT NULL,
    restock_quantity INT NOT NULL,
    brand_partner_id INT NOT NULL,
    restock_date DATE,
    FOREIGN KEY (brand_partner_id) REFERENCES users(user_id),
    FOREIGN KEY (item_id) REFERENCES items_inventory(item_id)
);

CREATE TABLE audit_log (
    audit_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    action VARCHAR(50) NOT NULL,
    table_name VARCHAR(50) NOT NULL,
    record_id INT NOT NULL,
    old_data JSON NULL,
    new_data JSON NULL,
    changed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);


-- 5) INSERT SAMPLE DATA

-- 5.1) Insert sample users
-- Notice we have a hashed password (pretend these are hashed for demonstration).
INSERT INTO users
(user_role_id, username, password_hash, user_email, user_phone, user_address, user_status_id, user_verified_id)
VALUES
(4, 'Alice N. De Leon',   'hash_of_alicepw',   'alice@gmail.com',   '1234567890', '123 Main St',                   1, 1),
(4, 'Bobie Cruz',         'hash_of_bobpw',     'bob@gmail.com',     '0987654321', '456 Elm St',                    1, 1),
(4, 'Charlie Sese',       'hash_of_charliepw', 'charlie@gmail.com', '1122334455', '789 Oak St',                    1, 1),
(4, 'Althea Ashley',      'hash_of_ashleypw',  'ashley@gmail.com',  '09196783223','Meycauayan Baliuag Bulacan',    1, 1),
(4, 'Kate Ocampo',        'hash_of_katepw',    'kateocampo@gmail.com','09454086527','Tabang Plaridel Bulacan',      1, 1),
(4, 'Nicole Reyes',       'hash_of_nickpw',    'nicolereyes@gmail.com','09261718429','San Rafael Bulacan',          1, 1),
(1, 'Grayserr Geronimo',  'hash_of_pulilanpw', 'grayserrgeronimo@gmail.com','0928049233','Mateo Commercial Bldg',     1, 1),
(2, 'JC Santos',          'hash_of_staffpw',   'santosJC@gmail.com','09190978823','Sta Barbara Baliuag Bulacan',  1, 1),
(2, 'Melanie Cruz',       'hash_of_staff2pw',  'MelCruz209@gmail.com','09454095426','Sta Barbara Baliuag Bulacan', 1, 1),
(3, 'MJ Del Rosario',     'hash_of_brandpw',   'michaeljames@gmail.com','09285427405','Sta Barbara Baliuag Bulacan',1, 1);

-- 5.2) Insert some items
INSERT INTO items_inventory
    (item_name, item_category_id, item_description, item_price, item_cost, item_stock, item_date, price_effective_date, price_expiration_date, item_status_id)
VALUES
('BNW-CTB',   1, 'BNW-CTB Product',        50.00,  30.00, 10, CURDATE(), CURDATE(), '2025-12-31', 1),
('AAC-AP',    2, 'AAC-AP Product',         69.00,  40.00, 15, CURDATE(), CURDATE(), '2025-12-31', 1),
('ALI-BPT',   3, 'ALI-BPT Product',       120.00,  60.00, 20, CURDATE(), CURDATE(), '2025-12-31', 1),
('ALI-MFB',   3, 'mofusand blind bag',    200.00, 150.00, 12, CURDATE(), CURDATE(), '2025-12-31', 1),
('AAC-WP-S',  2, 'AAC waterproof sticker', 49.00,  30.00,  5, CURDATE(), CURDATE(), '2025-12-31', 1),
('AMC-DCBG',  4, 'AMC-Decoden-Bag',       600.00, 500.00,  9, CURDATE(), CURDATE(), '2025-12-31', 1),
('AMC-GISTK', 4, 'AMC-Genshin-Sticker',    30.00,  15.00,  8, CURDATE(), CURDATE(), '2025-12-31', 1),
('BNW-BXP',   5, 'Princess Brix',         118.00,  90.00,  9, CURDATE(), CURDATE(), '2025-12-31', 1),
('DCS-HSM',   6, 'DCS-Harry-Styles-Ears', 175.00, 120.00,  7, CURDATE(), CURDATE(), '2025-12-31', 1),
('DCS-PFX',   6, 'DCS-Pastel-Flowers',    275.00, 230.00,  3, CURDATE(), CURDATE(), '2025-12-31', 1);

-- 5.3) Insert sample orders
INSERT INTO orders
    (transaction_type_id, transaction_mode_id, customer_id, order_date, discount, total_amount, employee_id, order_status_id)
VALUES
(1, 1, 1, '2024-12-01', 0.15,  85.00,  NULL, 1),
(2, 2, 2, '2024-12-05', 0.10,  62.10, 10,   2),
(1, 2, 3, '2024-12-05', 0.00, 360.00, 8,    3),
(1, 1, 4, '2024-12-05', 0.00,  50.00, NULL, 1),
(1, 1, 2, '2024-12-05', 0.15, 481.95, NULL, 1),
(2, 2, 2, '2024-12-05', 0.10, 169.20, 10,   2),
(1, 1, 3, '2024-12-05', 0.00,  69.00, 8,    3),
(1, 1, 1, '2024-12-05', 0.00, 410.00, NULL, 1),
(2, 2, 6, '2024-12-05', 0.05, 717.25, NULL, 1),
(1, 1, 3, '2024-12-05', 0.00,  49.00, NULL, 1),
(2, 2, 7, '2024-12-05', 0.00,  29.00, NULL, 1),
(1, 1, 2, '2024-12-09', 0.00, 150.00, NULL, 1),
(2, 2, 9, '2024-12-13', 0.00,  25.00, NULL, 1),
(2, 1, 1, '2024-12-17', 0.00, 100.00, NULL, 1),
(1, 2, 5, '2024-12-21', 0.00,1000.00, NULL, 1),
(1, 1, 4, '2024-12-25', 0.00, 700.00, NULL, 1),
(2, 2, 6, '2024-12-29', 0.00, 100.00, NULL, 1),
(1, 1, 8, '2025-01-02', 0.00, 150.00, NULL, 1),
(2, 2, 2, '2025-01-04', 0.00, 200.00, NULL, 1),
(1, 1, 1, '2024-04-28', 0.15,  85.00, NULL, 1),
(2, 2, 3, '2024-05-05', 0.10,  62.10, 10,   2),
(1, 1, 5, '2024-05-15', 0.00, 360.00, 8,    3),
(2, 2, 2, '2024-05-25', 0.00,  50.00, NULL, 1),
(1, 1, 4, '2024-06-01', 0.15, 481.95, NULL, 1),
(2, 2, 6, '2024-07-28', 0.10, 169.20, 10,   2),
(1, 1, 2, '2024-08-05', 0.00,  69.00, 8,    3),
(2, 2, 8, '2024-08-15', 0.00, 410.00, NULL, 1),
(1, 1, 3, '2024-08-25', 0.05, 717.25, NULL, 1),
(2, 2, 1, '2024-08-31', 0.00, 500.00, 10,   3),
(1, 1, 2, '2024-11-02', 0.00,3663.00, NULL, 3),
(1, 1, 2, '2024-11-03', 0.00, 802.00, NULL, 3),
(1, 1, 2, '2024-11-05', 0.00,2133.00, NULL, 3),
(1, 1, 2, '2024-11-06', 0.00,1653.00, NULL, 3),
(1, 1, 2, '2024-11-07', 0.00,3020.00, NULL, 3);

-- 5.4) Insert order items (including new item_discount if you want to use it)
INSERT INTO order_items (order_id, item_id, quantity, item_discount)
VALUES
(1, 1, 2, 0.00),
(2, 2, 1, 0.00),
(3, 3, 3, 0.00),
(4, 1, 1, 0.00),
(5, 2, 2, 0.00),
(5, 2, 1, 0.00),
(5, 3, 3, 0.00),
(6, 1, 1, 0.00),
(6, 2, 2, 0.00),
(7, 2, 1, 0.00),
(8, 3, 3, 0.00),
(8, 1, 1, 0.00),
(9, 2, 2, 0.00),
(9, 2, 1, 0.00),
(9, 3, 3, 0.00),
(9, 1, 1, 0.00),
(9, 2, 2, 0.00),
(10,1, 1, 0.00),
(11,2, 1, 0.00),
(12,3, 2, 0.00),
(13,4, 1, 0.00),
(14,5, 1, 0.00),
(15,6, 1, 0.00),
(16,7, 2, 0.00),
(17,8, 1, 0.00),
(18,9, 1, 0.00),
(19,10,1, 0.00),
(20,1, 1, 0.00),
(21,2, 1, 0.00),
(22,3, 1, 0.00),
(23,4, 1, 0.00),
(24,5, 1, 0.00),
(25,6, 1, 0.00),
(26,7, 1, 0.00),
(27,8, 1, 0.00),
(28,9, 1, 0.00),
(29,10,1, 0.00),
(30,1, 3, 0.00),
(31,2, 2, 0.00),
(32,3, 2, 0.00),
(33,4, 2, 0.00),
(34,5, 2, 0.00);

-- 5.5) Insert refunds, plus partial-refund items if desired
INSERT INTO refunds (order_id, refunded_amount, refund_reason, employee_id)
VALUES
(1, 50.00, 'Item defect', 8);

-- Example partial refund for the same refund_id=1 if you had item-level details:
-- Note: order_items_id=1 does not exist in above sample, so adjust accordingly.
-- INSERT INTO refund_items (refund_id, order_items_id, quantity_refunded)
-- VALUES
-- (1, 1, 1);

-- 5.6) Restock table
INSERT INTO restock(shipment_number, item_id, restock_quantity, brand_partner_id, restock_date)
VALUES
('7000050894', 1, 10, 10, '2024-12-24'),
('7000050894', 2, 10, 10, '2024-12-24'),
('7000050894', 4, 5,  10, '2024-12-24'),
('7000050894', 6, 10, 10, '2024-12-24'),
('7000050895', 3, 10, 10, '2025-01-02'),
('7000050895', 5, 10, 10, '2025-01-02'),
('7000050895', 7, 10, 10, '2025-01-02'),
('7000050895', 8, 10, 10, '2025-01-02');

-- 6) Sample Queries (unchanged except for referencing new table name "users")

-- Display processed orders paid via PayMongo
SELECT 
    o.order_id, 
    tt.trans_type_name AS transaction_type, 
    tm.trans_mode_name AS transaction_mode, 
    c.username AS customer_name, 
    o.order_date, 
    o.discount, 
    o.total_amount, 
    e.username AS employee_name, 
    os.order_status_name AS order_status
FROM orders AS o
JOIN transaction_type  AS tt ON o.transaction_type_id = tt.trans_type_id
JOIN transaction_mode  AS tm ON o.transaction_mode_id = tm.trans_mode_id
JOIN users             AS c  ON o.customer_id        = c.user_id
LEFT JOIN users        AS e  ON o.employee_id        = e.user_id
JOIN order_status      AS os ON o.order_status_id    = os.order_status_id
WHERE os.order_status_name = 'Order Processed'
  AND tm.trans_mode_name  = 'PayMongo'
ORDER BY o.order_date ASC;

-- Total Sales by Item (quantity and total sales)
SELECT 
    i.item_name,
    ic.category_name AS item_category,
    DATE(o.order_date) AS order_date,
    SUM(oi.quantity) AS total_quantity_sold,
    SUM(oi.quantity * i.item_price) AS total_sales
FROM order_items AS oi
JOIN items_inventory AS i  ON oi.item_id = i.item_id
JOIN item_category    AS ic ON i.item_category_id = ic.category_id
JOIN orders           AS o  ON oi.order_id = o.order_id
JOIN order_status     AS os ON o.order_status_id = os.order_status_id
WHERE os.order_status_name IN ('Order Processed', 'Order Completed')
GROUP BY i.item_name, ic.category_name, DATE(o.order_date)
ORDER BY order_date, total_sales DESC;

-- Display All Inventory
SELECT
  i.item_id,
  i.item_name,
  ic.category_name AS item_category,
  i.item_price,
  i.item_cost,
  i.item_stock,
  i.item_date,
  i.price_effective_date,
  i.price_expiration_date,
  st.item_status_name
FROM items_inventory AS i
JOIN item_category AS ic ON i.item_category_id = ic.category_id
JOIN item_status   AS st ON i.item_status_id   = st.item_status_id
ORDER BY i.item_id;

-- Daily Sales Summary (for example date 2024-04-28)
SELECT 
    DATE(o.order_date) AS SaleDate,
    COUNT(o.order_id) AS TotalOrders,
    SUM(o.total_amount) AS DailySales
FROM orders AS o
WHERE o.order_date = '2024-04-28'
GROUP BY DATE(o.order_date)
ORDER BY DATE(o.order_date);

-- Weekly Sales Summary (example for entire 2024)
SELECT 
    MIN(DATE(o.order_date)) AS WeekStart,
    MAX(DATE(o.order_date)) AS WeekEnd,
    COUNT(o.order_id) AS TotalOrders,
    SUM(o.total_amount) AS WeeklySales
FROM orders AS o
WHERE o.order_date BETWEEN '2024-01-01' AND '2024-12-31'
GROUP BY WEEK(o.order_date, 1)
ORDER BY WEEK(o.order_date, 1);

-- Monthly Sales Summary
SELECT 
    DATE_FORMAT(o.order_date, '%Y-%M-%d') AS OrderMonth,
    COUNT(o.order_id) AS TotalOrders,
    SUM(o.total_amount) AS MonthlySales
FROM orders AS o
GROUP BY DATE_FORMAT(o.order_date, '%Y-%M-%d')
ORDER BY OrderMonth;

-- Last Three Months Sales
SELECT
    o.order_id,
    DATE(o.order_date) AS OrderDate,
    o.total_amount
FROM orders AS o
WHERE o.order_date >= DATE_SUB((SELECT MAX(order_date) FROM orders), INTERVAL 3 MONTH)
ORDER BY o.order_date;

-- Orders after September 1, 2024
SELECT 
    o.order_id,
    DATE_FORMAT(o.order_date, '%M %d, %Y') AS OrderDate,
    o.total_amount
FROM orders o
WHERE o.order_date >= '2024-09-01'
ORDER BY o.order_date;

-- Orders after September 1, 2024 with items
SELECT 
    o.order_id,
    DATE_FORMAT(o.order_date, '%M %d, %Y') AS OrderDate,
    o.total_amount,
    GROUP_CONCAT(i.item_name SEPARATOR ', ') AS ItemsOrdered
FROM orders o
JOIN order_items oi ON o.order_id = oi.order_id
JOIN items_inventory i ON oi.item_id = i.item_id
WHERE o.order_date >= '2024-09-01'
GROUP BY o.order_id, o.order_date, o.total_amount
ORDER BY o.order_date;

-- List of customers
SELECT 
    u.user_id, 
    u.username, 
    r.role_name AS user_role, 
    s.status_name AS user_status, 
    v.verified_name AS verified_status
FROM users AS u
JOIN user_role      AS r ON u.user_role_id   = r.role_id
JOIN status         AS s ON u.user_status_id = s.status_id
JOIN verified_status AS v ON u.user_verified_id = v.verified_id
WHERE r.role_name = 'Customer'
ORDER BY u.user_id;

-- Display Verified Users
SELECT 
    u.user_id, 
    u.username, 
    r.role_name AS user_role, 
    s.status_name AS user_status, 
    v.verified_name AS verified_status, 
    u.modified_at
FROM users AS u
JOIN user_role      AS r ON u.user_role_id   = r.role_id
JOIN status         AS s ON u.user_status_id = s.status_id
JOIN verified_status AS v ON u.user_verified_id = v.verified_id
WHERE v.verified_name = 'Verified'
ORDER BY u.user_id;

-- Display Active Users
SELECT 
    u.user_id, 
    u.username, 
    r.role_name AS user_role, 
    s.status_name AS user_status, 
    v.verified_name AS verified_status
FROM users AS u
JOIN user_role      AS r ON u.user_role_id   = r.role_id
JOIN status         AS s ON u.user_status_id = s.status_id
JOIN verified_status AS v ON u.user_verified_id = v.verified_id
WHERE s.status_name = 'Active'
ORDER BY u.user_id;

-- Orders Completed Dates
SELECT
    o.order_id, 
    o.order_date AS OrderCreated,
    CASE WHEN os.order_status_name = 'Order Completed' THEN o.order_date ELSE NULL END AS OrderCompleted, 
    o.total_amount,
    c.username AS CustomerName,
    os.order_status_name AS OrderStatus
FROM orders o
JOIN order_status os ON o.order_status_id = os.order_status_id
JOIN users c        ON o.customer_id      = c.user_id
ORDER BY o.order_date;

-- Sales Tracking
SELECT 
    o.order_id,
    DATE_FORMAT(o.order_date, '%M %d, %Y') AS OrderCreated,
    IF(os.order_status_name = 'Order Completed', DATE_FORMAT(o.order_date, '%M %d, %Y'), NULL) AS OrderCompleted,
    o.total_amount,
    c.username AS CustomerName,
    os.order_status_name AS OrderStatus
FROM orders o
JOIN order_status os ON o.order_status_id = os.order_status_id
JOIN users c         ON o.customer_id      = c.user_id
ORDER BY o.order_date ASC;

-- Customer Sales Summary Report
SELECT 
    u.username AS CustomerName,
    COUNT(o.order_id) AS TotalOrders,
    SUM(o.total_amount) AS TotalSales
FROM orders o
JOIN users u ON o.customer_id = u.user_id
GROUP BY u.username
ORDER BY TotalSales DESC;

-- Employee Sales
SELECT 
    e.username AS EmployeeName,
    COUNT(o.order_id) AS OrdersHandled,
    SUM(o.total_amount) AS TotalSales
FROM orders o
JOIN users e ON o.employee_id = e.user_id
WHERE o.employee_id IS NOT NULL
GROUP BY e.username
ORDER BY TotalSales DESC;
