-- DATOS DE PRUEBA
-- Usuario administrador
INSERT INTO users (username, email, password, role) 
VALUES 
('admin', 'admin@example.com', 'admin123', 'admin');

-- Alojamiento de ejemplo
INSERT INTO accommodations (name, location, price, description, image_url) 
VALUES 
('Hotel Paradise', 'Beach City', 150.00, 'Luxury hotel near the beach.', 'https://images.pexels.com/photos/3935311/pexels-photo-3935311.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1'),
('Mountain Escape', 'Highlands', 90.00, 'Cozy cabin with mountain views.', 'https://images.pexels.com/photos/3935348/pexels-photo-3935348.jpeg?auto=compress&cs=tinysrgb&w=600');
