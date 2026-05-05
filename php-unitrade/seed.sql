-- Clear existing data safely
SET FOREIGN_KEY_CHECKS = 0;
-- We use DELETE instead of TRUNCATE for better compatibility with foreign keys in some environments
DELETE FROM item_images;
DELETE FROM items;
DELETE FROM categories;
DELETE FROM profiles;
DELETE FROM user_roles;
DELETE FROM users;
SET FOREIGN_KEY_CHECKS = 1;

-- Reset Auto-increment
ALTER TABLE users AUTO_INCREMENT = 1;
ALTER TABLE categories AUTO_INCREMENT = 1;
ALTER TABLE items AUTO_INCREMENT = 1;

-- 1. Seed Users (Admin and sample student)
INSERT INTO users (id, name, email, password) VALUES
(1, 'Yeabsira Admin', 'yeabsiragetachew613@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'), -- Standard test hash (password)
(2, 'Student User', 'student@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

INSERT INTO user_roles (user_id, role) VALUES (1, 'admin'), (2, 'student');

INSERT INTO profiles (user_id, full_name, ugr_id, astu_email, telegram_username, phone, department, year_of_study) VALUES
(1, 'Yeabsira Admin', 'ADM/001/16', 'yeabsiragetachew613@gmail.com', '@yeabsira_admin', '+251900000000', 'IT', 4),
(2, 'Student One', 'UGR/35614/16', 'student_one@gmail.com', '@student_one', '+251912345678', 'Software Engineering', 3);

-- 2. Categories
INSERT INTO categories (id, `key`, label, description, icon) VALUES
(1, 'electronics', 'Electronics', 'Laptops, phones, accessories', 'laptop'),
(2, 'stationery', 'Stationery', 'Books, pens, notebooks', 'book'),
(3, 'clothes', 'Clothes', 'Apparel, jackets, traditional wear', 'shirt'),
(4, 'shoes', 'Shoes', 'Sneakers, formals, sandals', 'footprints'),
(5, 'food', 'Food & Beverage', 'Injera, burgers, coffee, juices', 'utensils');

-- 3. Items (50 items total - 10 per category)
INSERT INTO items (title, category_id, price_etb, `condition`, description, seller_id, status, image_url) VALUES
-- Electronics (10 items)
('MacBook Air M1', 1, 65000, 'used', '8GB RAM, 256GB SSD. Perfect for coding.', 2, 'approved', 'https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?q=80&w=500'),
('Samsung Galaxy S22', 1, 35000, 'used', 'Excellent condition, minor scratches.', 2, 'approved', 'https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?q=80&w=500'),
('Sony WH-1000XM4', 1, 12000, 'used', 'Noise canceling headphones.', 2, 'approved', 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?q=80&w=500'),
('Dell 24-inch Monitor', 1, 9500, 'used', 'Full HD monitor, dual input.', 2, 'approved', 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?q=80&w=500'),
('Wireless Mouse & Keyboard', 1, 1500, 'new', 'Logitech MK270 combo.', 2, 'approved', 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?q=80&w=500'),
('Power Bank 20000mAh', 1, 2200, 'new', 'Anker PowerCore.', 2, 'approved', 'https://images.unsplash.com/photo-1609592424085-f688849764b8?q=80&w=500'),
('HP Laptop Charger', 1, 1200, 'used', 'Original HP charger, 65W.', 2, 'approved', 'https://images.unsplash.com/photo-1585338107529-13afc5f02586?q=80&w=500'),
('USB-C Hub (7-in-1)', 1, 3000, 'new', 'HDMI, USB 3.0 slots.', 2, 'approved', 'https://images.unsplash.com/photo-1591411082056-a1d133a82909?q=80&w=500'),
('iPad Pro 11-inch', 1, 45000, 'used', 'Apple Pencil 2 included.', 2, 'approved', 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?q=80&w=500'),
('WiFi Router TP-Link', 1, 2500, 'used', 'Dual band AC1200.', 2, 'approved', 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?q=80&w=500'),

-- Stationery (10 items)
('Scientific Calculator 991EX', 2, 1800, 'used', 'Essential for engineering.', 2, 'approved', 'https://images.unsplash.com/photo-1543185377-99cd19911180?q=80&w=500'),
('Engineering Drawing Set', 2, 2500, 'used', 'Complete drafting set.', 2, 'approved', 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?q=80&w=500'),
('Hardbound Notebooks (3)', 2, 600, 'new', 'Premium ruled notebooks.', 2, 'approved', 'https://images.unsplash.com/photo-1531346878377-a5be20888e57?q=80&w=500'),
('Stabilo Highlighters', 2, 450, 'new', 'Pack of 6 colors.', 2, 'approved', 'https://images.unsplash.com/photo-1516962215378-7fa2e137ae93?q=80&w=500'),
('Technical Pens 0.1-0.8', 2, 1200, 'new', 'Pigment liners.', 2, 'approved', 'https://images.unsplash.com/photo-1585336139118-132f8f9d5fdb?q=80&w=500'),
('Calculus - James Stewart', 2, 1500, 'used', 'Hardcover 8th edition.', 2, 'approved', 'https://images.unsplash.com/photo-1532012197267-da84d127e765?q=80&w=500'),
('Physics for Scientists', 2, 2200, 'used', 'Serway and Jewett.', 2, 'approved', 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?q=80&w=500'),
('Drafting Table Lamp', 2, 1100, 'used', 'Adjustable arm lamp.', 2, 'approved', 'https://images.unsplash.com/photo-1534073828943-f801091bb18c?q=80&w=500'),
('Sticky Notes Pack', 2, 350, 'new', 'Various sizes.', 2, 'approved', 'https://images.unsplash.com/photo-1583521214690-73421a1829a9?q=80&w=500'),
('Whiteboard Markers', 2, 250, 'new', 'Pack of 4 colors.', 2, 'approved', 'https://images.unsplash.com/photo-1596464716127-f2a82984de30?q=80&w=500'),

-- Clothes (10 items)
('ASTU Branding Hoodie', 3, 1200, 'new', 'Blue hoodie with logo.', 2, 'approved', 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?q=80&w=500'),
('Leather Jacket', 3, 3500, 'used', 'Genuine leather, Size L.', 2, 'approved', 'https://images.unsplash.com/photo-1551028711-0305ed979603?q=80&w=500'),
('Levi s Denim Jacket', 3, 2800, 'used', 'Original, Size M.', 2, 'approved', 'https://images.unsplash.com/photo-1551537482-f2075a1d41f2?q=80&w=500'),
('Plaid Flannel Shirt', 3, 850, 'used', 'Warm and comfy.', 2, 'approved', 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?q=80&w=500'),
('Navy Blue Overcoat', 3, 4500, 'used', 'Formal events.', 2, 'approved', 'https://images.unsplash.com/photo-1539533377285-a74094a961aa?q=80&w=500'),
('Nike Sport Shorts', 3, 900, 'used', 'Dri-FIT tech.', 2, 'approved', 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=500'),
('Casual T-shirts (5)', 3, 1500, 'new', 'Basic colors set.', 2, 'approved', 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?q=80&w=500'),
('Woolen Beanie Set', 3, 700, 'new', 'Scarf and hat.', 2, 'approved', 'https://images.unsplash.com/photo-1485960994840-902a67e187c8?q=80&w=500'),
('Beige Chino Pants', 3, 1300, 'used', 'Slim fit 32.', 2, 'approved', 'https://images.unsplash.com/photo-1473966968600-fa801b69996d?q=80&w=500'),
('North Face Windbreaker', 3, 3200, 'used', 'Waterproof.', 2, 'approved', 'https://images.unsplash.com/photo-1544022613-e87ca75a784a?q=80&w=500'),

-- Shoes (10 items)
('Nike Air Force 1', 4, 4500, 'used', 'Classic white.', 2, 'approved', 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?q=80&w=500'),
('Adidas Ultraboost', 4, 6000, 'used', 'Running shoes.', 2, 'approved', 'https://images.unsplash.com/photo-1587563871167-1ee9c731aefb?q=80&w=500'),
('Jordan 1 Chicago', 4, 8500, 'used', 'Retro High.', 2, 'approved', 'https://images.unsplash.com/photo-1560769629-975ec94e6a86?q=80&w=500'),
('Suede Chelsea Boots', 4, 3800, 'new', 'Handmade, Size 42.', 2, 'approved', 'https://images.unsplash.com/photo-1638247025967-b4e38f787b76?q=80&w=500'),
('Vans Old Skool', 4, 2500, 'used', 'Black/White.', 2, 'approved', 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?q=80&w=500'),
('Oxford Leather Shoes', 4, 3200, 'used', 'Formal polished.', 2, 'approved', 'https://images.unsplash.com/photo-1449247709967-d4461a6a6103?q=80&w=500'),
('Converse High Tops', 4, 2200, 'used', 'Classic Red.', 2, 'approved', 'https://images.unsplash.com/photo-1460353581641-37baddab0fa2?q=80&w=500'),
('Yeezy Dorm Slides', 4, 4000, 'new', 'Comfortable.', 2, 'approved', 'https://images.unsplash.com/photo-1603808033192-082d6919d3e1?q=80&w=500'),
('Timberland Boots', 4, 5500, 'used', 'Heavy duty.', 2, 'approved', 'https://images.unsplash.com/photo-1520639889313-7272175b1c39?q=80&w=500'),
('Columbia Hiking Shoes', 4, 4200, 'used', 'Waterproof.', 2, 'approved', 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=500'),

-- Food (10 items)
('Fresh Spiced Injera', 5, 20, 'new', 'Fresh daily.', 2, 'approved', 'https://images.unsplash.com/photo-1589113316274-9118e95188f5?q=80&w=500'),
('Coffee Beans 1kg', 5, 800, 'new', 'Yirgacheffe beans.', 2, 'approved', 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?q=80&w=500'),
('Energy Drink Pack', 5, 450, 'new', 'Monster (6pcs).', 2, 'approved', 'https://images.unsplash.com/photo-1622543953495-a270a377041c?q=80&w=500'),
('Instant Noodles Box', 5, 1200, 'new', '24 packets Indomie.', 2, 'approved', 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?q=80&w=500'),
('Student Snack Box', 5, 350, 'new', 'Mixed snacks.', 2, 'approved', 'https://images.unsplash.com/photo-1621939514649-280e2ee17f60?q=80&w=500'),
('Natural Honey 500g', 5, 550, 'new', 'Pure honey.', 2, 'approved', 'https://images.unsplash.com/photo-1587049352846-4a222e783137?q=80&w=500'),
('Kericho Tea Leaves', 5, 400, 'new', 'Black tea.', 2, 'approved', 'https://images.unsplash.com/photo-1594631252845-29fc458631b6?q=80&w=500'),
('Dorm Spices Set', 5, 650, 'new', 'Mitmita & Berbere.', 2, 'approved', 'https://images.unsplash.com/photo-1506368249639-73a05d6f6488?q=80&w=500'),
('Assorted Juice Pack', 5, 900, 'new', '10 tetra packs.', 2, 'approved', 'https://images.unsplash.com/photo-1613478223719-2ab802602423?q=80&w=500'),
('Peanut Butter 1kg', 5, 750, 'new', 'Healthy & organic.', 2, 'approved', 'https://images.unsplash.com/photo-1534723328310-e82dad3ee43f?q=80&w=500');
