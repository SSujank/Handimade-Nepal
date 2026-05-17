CREATE DATABASE IF NOT EXISTS handicraft_store_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE handicraft_store_db;

DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS contact_messages;
DROP TABLE IF EXISTS testimonials;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('customer','admin') NOT NULL DEFAULT 'customer',
    phone VARCHAR(30) NULL,
    address VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(80) NOT NULL UNIQUE,
    description VARCHAR(255) NULL
) ENGINE=InnoDB;

CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    product_name VARCHAR(120) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    image_url VARCHAR(500) NOT NULL,
    is_featured TINYINT(1) NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    customer_name VARCHAR(100) NOT NULL,
    customer_email VARCHAR(120) NOT NULL,
    customer_phone VARCHAR(30) NOT NULL,
    shipping_address VARCHAR(255) NOT NULL,
    notes TEXT NULL,
    total_amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    status ENUM('Pending','Confirmed','Packed','Shipped','Delivered','Cancelled') NOT NULL DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE order_items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    product_name VARCHAR(120) NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    line_total DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE contact_messages (
    message_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL,
    phone VARCHAR(30) NULL,
    topic VARCHAR(50) NOT NULL,
    subject VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    newsletter TINYINT(1) NOT NULL DEFAULT 0,
    consent TINYINT(1) NOT NULL DEFAULT 1,
    status ENUM('New','Read','Replied') NOT NULL DEFAULT 'New',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE testimonials (
    testimonial_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    location VARCHAR(100) NOT NULL,
    rating TINYINT NOT NULL DEFAULT 5,
    comment TEXT NOT NULL,
    is_approved TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO users (full_name, email, password_hash, role, phone, address) VALUES
('Admin User', 'admin@handicraftnepal.com', '$2y$12$4M/rluV/xYin/Dg42s7QNOoAs455A2nm8u3yvMr/xbjkTHFfVIw16', 'admin', '+61 400 000 000', 'Sydney NSW Australia'),
('Demo Customer', 'customer@example.com', '$2y$12$B9Or1.uvH.KauYe4t0jI/uCBy0OyQS/ERWYouoKfCR.jc8sXF/v1q', 'customer', '+61 411 222 333', 'Newcastle NSW Australia');

INSERT INTO categories (category_name, description) VALUES
('Meditation', 'Singing bowls, prayer wheels and calming spiritual items.'),
('Textiles', 'Pashmina, Dhaka fabric, scarves and hand-loomed products.'),
('Statues', 'Buddha statues, ritual figures and traditional metalwork.'),
('Felt & Decor', 'Handmade felt items, garlands, ornaments and home decoration.'),
('Jewellery', 'Traditional Nepali jewellery and artisan accessories.'),
('Art & Masks', 'Thangka paintings, masks and wall art.'),
('Pottery', 'Clay cups, bowls and handmade ceramic items.');

INSERT INTO products (category_id, product_name, description, price, stock, image_url, is_featured) VALUES
(1, 'Tibetan Singing Bowl', 'Seven-metal hand-hammered singing bowl made by artisans in Patan. Includes cushion and wooden mallet.', 89.00, 18, 'images/products/singing_bowl_final.png', 1),
(3, 'Bronze Buddha Statue', 'Lost-wax cast bronze Buddha statue in meditation pose. A meaningful decor piece for homes and meditation spaces.', 145.00, 8, 'images/products/bronze_buddha_statue_final.png', 1),
(2, 'Pure Pashmina Shawl', 'Soft Himalayan cashmere shawl, hand-loomed in Kathmandu. Lightweight, warm and suitable for gifts.', 95.00, 14, 'images/products/pure_pashmina_shawl_final.png', 1),
(4, 'Felt Ball Garland', 'Colourful hand-rolled wool felt garland made by a women-led cooperative in Nepal.', 28.00, 35, 'images/products/felt_ball_garland_final.png', 1),
(6, 'Thangka Wall Painting', 'Traditional Buddhist thangka painting on cotton canvas using intricate iconography and mineral-inspired colours.', 165.00, 6, 'images/products/thangka_wall_painting_final.png', 1),
(2, 'Dhaka Topi and Scarf Set', 'Traditional Nepali Dhaka cap with matching scarf, woven with geometric cultural patterns.', 58.00, 20, 'images/products/dhaka_topi_scarf_set_final.png', 0),
(5, 'Turquoise Silver Necklace', 'Handmade statement necklace with turquoise-style stones and silver-tone detailing.', 76.00, 11, 'images/products/turquoise_silver_necklace_final.png', 0),
(7, 'Clay Tea Cup Set', 'Set of four handmade clay cups inspired by traditional Nepali tea culture.', 42.00, 24, 'images/products/clay_tea_cup_set_final.png', 0),
(6, 'Traditional Wooden Mask', 'Hand-painted decorative wooden mask inspired by Himalayan festival traditions.', 52.00, 13, 'images/products/traditional_wooden_mask_final.png', 0),
(1, 'Mini Prayer Wheel', 'Small brass prayer wheel suitable for desk decor and spiritual gift sets.', 39.00, 22, 'images/products/mini_prayer_wheel_final.png', 0),
(6, 'Lokta Paper Journal', 'Handmade journal crafted from durable Nepali lokta paper with a simple artisan finish.', 24.00, 30, 'images/products/lokta_paper_journal_final.png', 0),
(6, 'Mithila Greeting Card Set', 'Set of decorative greeting cards inspired by Mithila-style folk art motifs and bright colours.', 19.00, 26, 'images/products/mithila_card_set_final.png', 0),
(2, 'Yak Wool Blanket', 'Warm handwoven blanket inspired by mountain textile traditions, suitable for sofa throws or travel.', 110.00, 9, 'images/products/yak_wool_blanket_final.png', 0),
(7, 'Copper Water Bottle', 'Traditional copper bottle for everyday hydration, finished with a warm handcrafted look.', 33.00, 17, 'images/products/copper_water_bottle_final.png', 0),
(1, 'Incense Holder Set', 'Wooden incense holder with a starter set of incense sticks for calm home rituals.', 21.00, 29, 'images/products/incense_holder_set_final.png', 0),
(2, 'Hemp Tote Bag', 'Eco-friendly handwoven tote bag made from natural fibre and designed for daily use.', 37.00, 16, 'images/products/hemp_tote_bag_final.png', 0),
(3, 'Brass Butter Lamp', 'Traditional ritual lamp used in prayer spaces and meditation corners.', 48.00, 15, 'images/products/brass_butter_lamp_final.png', 0),
(4, 'Felted Wool Slippers', 'Soft handmade wool slippers designed for indoor comfort and warmth.', 34.00, 20, 'images/products/felted_wool_slippers_final.png', 0),
(4, 'Carved Window Frame Decor', 'Decorative wall art inspired by carved Newari window patterns from the Kathmandu Valley.', 72.00, 7, 'images/products/carved_window_frame_decor_final.png', 0),
(4, 'Prayer Flag Set', 'Set of colourful Himalayan prayer flags suitable for home, studio or garden decoration.', 18.00, 40, 'images/products/prayer_flag_set_final.png', 0);

INSERT INTO testimonials (customer_name, location, rating, comment) VALUES
('Maya R.', 'Melbourne, Australia', 5, 'The singing bowl arrived safely and the sound quality was beautiful. The packaging also explained the maker and the story behind the product.'),
('Daniel K.', 'Sydney, Australia', 5, 'I ordered a pashmina shawl as a gift. It felt authentic and the website was easy to use.'),
('Asha P.', 'Kathmandu, Nepal', 4, 'The product range feels close to real Nepali craft markets and the online ordering process was simple.'),
('Sarah L.', 'Newcastle, Australia', 5, 'The handmade felt garland was colourful and well-made. I liked that the store explains fair trade and artisan support.');
