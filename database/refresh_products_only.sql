USE handicraft_store_db;
DELETE FROM order_items;
DELETE FROM orders;
DELETE FROM products;
ALTER TABLE products AUTO_INCREMENT = 1;

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
