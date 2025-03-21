CREATE DATABASE bunniwinkle7;
USE bunniwinkle7;


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
 ('Bunniwinkle'),   -- 1
 ('Artaftercoffee'),-- 2
 ('ARTLIYAAAAH'),   -- 3
 ('AMAZEBALL CRAFT'), -- 4
 ('Bunni'),         -- 5
 ('DREAMERS CREATES'); -- 6

INSERT INTO item_status (item_status_name)
VALUES
 ('Available'),     -- 1
 ('Not Available'); -- 2

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



CREATE TABLE user(
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    user_role_id INT NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    user_password VARCHAR(250) NOT NULL,
    user_email VARCHAR(250) UNIQUE NOT NULL,
    user_phone VARCHAR(25) NOT NULL,
    user_address VARCHAR(250) NOT NULL,
    user_status_id INT NOT NULL,
    user_verified_id INT NOT NULL DEFAULT 2,
    modified_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_role_id) REFERENCES user_role(role_id),
    FOREIGN KEY (user_status_id) REFERENCES status(status_id),
    FOREIGN KEY (user_verified_id) REFERENCES verified_status(verified_id)
);

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
    FOREIGN KEY (item_status_id) REFERENCES item_status(item_status_id)
);

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
    FOREIGN KEY (customer_id) REFERENCES user(user_id),
    FOREIGN KEY (employee_id) REFERENCES user(user_id),
    FOREIGN KEY (order_status_id) REFERENCES order_status(order_status_id)
);

CREATE TABLE order_items(
    order_items_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    item_id INT NOT NULL,
    quantity INT NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    FOREIGN KEY (item_id) REFERENCES items_inventory(item_id)
);

-- 4.5) REFUNDS TABLE
CREATE TABLE refunds(
    refund_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    refunded_amount DECIMAL(10,2),
    refund_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    refund_reason VARCHAR(250) NOT NULL,
    employee_id INT,
    FOREIGN KEY (employee_id) REFERENCES user(user_id),
    FOREIGN KEY (order_id) REFERENCES orders(order_id)
);

-- 4.6) RESTOCK TABLE
CREATE TABLE restock(
    restock_id INT AUTO_INCREMENT PRIMARY KEY,
    shipment_number VARCHAR(250) NOT NULL,
    item_id INT NOT NULL,
    restock_quantity INT NOT NULL,
    brand_partner_id INT NOT NULL,
    restock_date DATE,
    FOREIGN KEY (brand_partner_id) REFERENCES user(user_id),
    FOREIGN KEY (item_id) REFERENCES items_inventory(item_id)
);


-- role_id (1='Owner/Admin', 2='Staff', 3='Brand Partner', 4='Customer')
INSERT INTO user (user_role_id, username, user_password, user_email, user_phone, user_address, user_status_id, user_verified_id)
VALUES
(4, 'Alice N. De Leon', 'alicepw', 'alice@gmail.com', '1234567890', '123 Main St', 1, 1),
(4, 'Bobie Cruz',       'bobpw',   'bob@gmail.com',   '0987654321', '456 Elm St', 1, 1),
(4, 'Charlie Sese',     'charliepw','charlie@gmail.com','1122334455','789 Oak St', 1, 1),
(4, 'Althea Ashley',    'altheaAshley','ashley@gmail.com','09196783223','Meycauayan Baliuag Bulacan',1,1),
(4, 'Kate Ocampo',      'ocampoKate','kateocampo@gmail.com','09454086527','Tabang Plaridel Bulacan',1,1),
(4, 'Nicole Reyes',     'nickreyes','nicolereyes@gmail.com','09261718429','San Rafael Bulacan',1,1),
(1, 'Grayserr Geronimo','pulilanpw','grayserrgeronimo@gmail.com','0928049233','Mateo Commercial Bldg, Longos, Pulilan',1,1),
(2, 'JC Santos',     'pulilanPssword','santosJC@gmail.com','09190978823','Sta Barbara Baliuag Bulacan',1,1),
(2, 'Melanie Cruz',  'meycauayanpw','MelCruz209@gmail.com','09454095426','Sta Barbara Baliuag Bulacan',1,1),
(3, 'MJ Del Rosario','brandpartnercorp','michaeljames@gmail.com','09285427405','Sta Barbara Baliuag Bulacan',1,1);

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

INSERT INTO orders
    (transaction_type_id, transaction_mode_id, customer_id, order_date, discount, total_amount, employee_id, order_status_id)
VALUES
(1, 1, 1, '2024-12-01', 0.15, 85.00, NULL, 1),
(2, 2, 2, '2024-12-05', 0.10, 62.10, 10, 2),
(1, 2, 3, '2024-12-05', 0.00, 360.00, 8, 3),
(1, 1, 4, '2024-12-05', 0.00, 50.00, NULL, 1),
(1, 1, 2, '2024-12-05', 0.15, 481.95, NULL, 1),
(2, 2, 2, '2024-12-05', 0.10, 169.20, 10, 2),
(1, 1, 3, '2024-12-05', 0.00, 69.00, 8, 3),
(1, 1, 1, '2024-12-05', 0.00, 410.00, NULL, 1),
(2, 2, 6, '2024-12-05', 0.05, 717.25, NULL, 1),
(1, 1, 3, '2024-12-05', 0.00, 49.00, NULL, 1),
(2, 2, 7, '2024-12-05', 0.00, 29.00, NULL, 1),
(1, 1, 2, '2024-12-09', 0.00, 150.00, NULL, 1),
(2, 2, 9, '2024-12-13', 0.00, 25.00, NULL, 1),
(2, 1, 1, '2024-12-17', 0.00, 100.00, NULL, 1),
(1, 2, 5, '2024-12-21', 0.00, 1000.00, NULL, 1),
(1, 1, 4, '2024-12-25', 0.00, 700.00, NULL, 1),
(2, 2, 6, '2024-12-29', 0.00, 100.00, NULL, 1),
(1, 1, 8, '2025-01-02', 0.00, 150.00, NULL, 1),
(2, 2, 2, '2025-01-04', 0.00, 200.00, NULL, 1),
(1, 1, 1, '2024-04-28', 0.15, 85.00, NULL, 1),
(2, 2, 3, '2024-05-05', 0.10, 62.10, 10, 2),
(1, 1, 5, '2024-05-15', 0.00, 360.00, 8, 3),
(2, 2, 2, '2024-05-25', 0.00, 50.00, NULL, 1),
(1, 1, 4, '2024-06-01', 0.15, 481.95, NULL, 1),
(2, 2, 6, '2024-07-28', 0.10, 169.20, 10, 2),
(1, 1, 2, '2024-08-05', 0.00, 69.00, 8, 3),
(2, 2, 8, '2024-08-15', 0.00, 410.00, NULL, 1),
(1, 1, 3, '2024-08-25', 0.05, 717.25, NULL, 1),
(2, 2, 1, '2024-08-31', 0.00, 500.00, 10, 3),
(1, 1, 2, '2024-11-02', 0.00, 3663.00,Null, 3),
(1, 1, 2, '2024-11-03', 0.00, 802.00,Null, 3),
(1, 1, 2, '2024-11-05', 0.00, 2133.00,Null, 3),
(1, 1, 2, '2024-11-06', 0.00, 1653.00,Null, 3),
(1, 1, 2, '2024-11-07', 0.00, 3020.00,Null, 3);

INSERT INTO order_items (order_id, item_id, quantity)
VALUES
(1, 1, 2),  
(2, 2, 1),  
(3, 3, 3),  
(4, 1, 1),  
(5, 2, 2),
(5, 2, 1),  
(5, 3, 3),
(6, 1, 1),  
(6, 2, 2),
(7, 2, 1),   
(8, 3, 3),  
(8, 1, 1),   
(9, 2, 2),
(9, 2, 1),   
(9, 3, 3),
(9, 1, 1),
(9, 2, 2),
(10, 1, 1),
(11, 2, 1),
(12, 3, 2),
(13, 4, 1),
(14, 5, 1),
(15, 6, 1),
(16, 7, 2),
(17, 8, 1),
(18, 9, 1),
(19, 10, 1),
(20, 1, 1),
(21, 2, 1),
(22, 3, 1),
(23, 4, 1),
(24, 5, 1),
(25, 6, 1),
(26, 7, 1),
(27, 8, 1),
(28, 9, 1),
(29, 10, 1),
(30, 1, 3),
(31, 2, 2),
(32, 3, 2),
(33, 4, 2),
(34, 5, 2);

INSERT INTO refunds (order_id, refunded_amount, refund_reason, employee_id)
VALUES
(1, 50.00, 'Item defect', 8);

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

-- PayMongo Cash Gcash
-- Order Received Order Processed Order Completed
-- Display processed orders 
SELECT o.order_id, tt.trans_type_name AS transaction_type, tm.trans_mode_name AS transaction_mode, 
       c.username AS customer_name, o.order_date, o.discount, o.total_amount, 
       e.username AS employee_name, os.order_status_name AS order_status
FROM orders AS o
JOIN transaction_type AS tt ON o.transaction_type_id = tt.trans_type_id
JOIN transaction_mode AS tm ON o.transaction_mode_id = tm.trans_mode_id
JOIN user AS c ON o.customer_id = c.user_id
LEFT JOIN user AS e ON o.employee_id = e.user_id
JOIN order_status AS os ON o.order_status_id = os.order_status_id
WHERE os.order_status_name = 'Order Processed' AND tm.trans_mode_name = 'PayMongo'
ORDER BY o.order_date ASC;

-- Total Sales by Item (quantity and total sales)
SELECT 
    i.item_name,
    ic.category_name AS item_category,
    DATE(o.order_date) AS order_date,
    SUM(oi.quantity) AS total_quantity_sold,
    SUM(oi.quantity * i.item_price) AS total_sales
FROM order_items AS oi
JOIN items_inventory AS i ON oi.item_id = i.item_id
JOIN item_category AS ic ON i.item_category_id = ic.category_id
JOIN orders AS o ON oi.order_id = o.order_id
JOIN order_status AS os ON o.order_status_id = os.order_status_id
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

-- Daily Sales Summary
SELECT 
    DATE(o.order_date) AS SaleDate,
    COUNT(o.order_id) AS TotalOrders,
    SUM(o.total_amount) AS DailySales
FROM orders AS o
WHERE o.order_date = '2024-04-28'
GROUP BY DATE(o.order_date)
ORDER BY DATE(o.order_date);

-- Weekly Sales Summary
SELECT 
    MIN(DATE(o.order_date)) AS WeekStart,
    MAX(DATE(o.order_date)) AS WeekEnd,
    COUNT(o.order_id) AS TotalOrders,
    SUM(o.total_amount) AS WeeklySales
FROM orders AS o
WHERE o.order_date BETWEEN '2024-01-01' AND '2024-12-31'
-- WHERE o.order_date BETWEEN '2024-05-05' AND '2024-05-12'
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

SELECT 
o.order_id,
DATE_FORMAT(o.order_date, '%M %d, %Y') AS OrderDate,
o.total_amount
FROM orders o
WHERE o.order_date >= '2024-09-01'
ORDER BY o.order_date;

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



-- List Admin/Staff/Customer
SELECT u.user_id, u.username, r.role_name AS user_role, s.status_name AS user_status, 
       v.verified_name AS verified_status
FROM user AS u
JOIN user_role AS r ON u.user_role_id = r.role_id
JOIN status AS s ON u.user_status_id = s.status_id
JOIN verified_status AS v ON u.user_verified_id = v.verified_id
WHERE r.role_name = 'Customer'
ORDER BY u.user_id;

-- Display Verified Users
SELECT u.user_id, u.username, r.role_name AS user_role, s.status_name AS user_status, 
       v.verified_name AS verified_status, u.modified_at
FROM user AS u
JOIN user_role AS r ON u.user_role_id = r.role_id
JOIN status AS s ON u.user_status_id = s.status_id
JOIN verified_status AS v ON u.user_verified_id = v.verified_id
WHERE v.verified_name = 'Verified'
ORDER BY u.user_id;

-- Display Active Users
SELECT u.user_id, u.username, r.role_name AS user_role, s.status_name AS user_status, 
       v.verified_name AS verified_status
FROM user AS u
JOIN user_role AS r ON u.user_role_id = r.role_id
JOIN status AS s ON u.user_status_id = s.status_id
JOIN verified_status AS v ON u.user_verified_id = v.verified_id
WHERE s.status_name = 'Active'
ORDER BY u.user_id;

-- Orders Completed Dates
SELECT
o.order_id, o.order_date AS OrderCreated,
CASE WHEN os.order_status_name = 'Order Completed' THEN o.order_date
ELSE NULL END AS OrderCompleted, o.total_amount,
c.username AS CustomerName,
os.order_status_name AS OrderStatus
FROM orders o
JOIN order_status os ON o.order_status_id = os.order_status_id
JOIN user c ON o.customer_id = c.user_id
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
JOIN user c ON o.customer_id = c.user_id
ORDER BY o.order_date ASC;


-- Customer Sales Summary Report
SELECT 
u.username AS CustomerName,
COUNT(o.order_id) AS TotalOrders,
SUM(o.total_amount) AS TotalSales
FROM orders o
JOIN user u ON o.customer_id = u.user_id
GROUP BY u.username
ORDER BY TotalSales DESC;


-- Employee Sales
SELECT 
e.username AS EmployeeName,
COUNT(o.order_id) AS OrdersHandled,
SUM(o.total_amount) AS TotalSales
FROM orders o
JOIN user e ON o.employee_id = e.user_id
WHERE o.employee_id IS NOT NULL
GROUP BY e.username
ORDER BY TotalSales DESC;

