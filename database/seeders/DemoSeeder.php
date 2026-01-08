<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        // Truncate tables to reset IDs
        DB::table('LOGS_ADMIN')->truncate();
        DB::table('REPORTS')->truncate();
        DB::table('NOTIFICATIONS')->truncate();
        DB::table('RATINGS')->truncate();
        DB::table('MESSAGES')->truncate();
        DB::table('BOOKINGS')->truncate();
        DB::table('TRIP_STOPS')->truncate();
        DB::table('TRIPS')->truncate();
        DB::table('VEHICLES')->truncate();
        DB::table('USERS')->truncate();
        DB::table('UNIVERSITIES')->truncate();

        // Insert Data
        DB::unprepared(<<<'SQL'
            INSERT INTO UNIVERSITIES (name, address, latitude, longitude, type) VALUES 
            ('La Citadelle', '10 Rue des Français Libres, 80080 Amiens', 49.914392, 2.298218, 'Campus'),
            ('Pôle Cathédrale', '10 Placette Lafleur, 80000 Amiens', 49.894548, 2.304033, 'Pôle Juridique/Eco'),
            ('Pôle Saint-Leu', '33 rue Saint-Leu, 80000 Amiens', 49.898864, 2.300588, 'Pôle Sciences'),
            ('Campus Santé', 'Avenue René Laennec, 80054 Amiens', 49.873264, 2.279854, 'Campus Santé'),
            ('IUT Amiens', 'Avenue des Facultés, 80025 Amiens', 49.877024, 2.261975, 'IUT'),
            ('ESIEE', '14 Quai de la Somme, 80080 Amiens', 49.897368, 2.292589, 'École d''ingénieur');

            INSERT INTO USERS (first_name, last_name, email, password, phone, role, bio, is_verified) VALUES 
            ('Admin', 'System', 'admin@blablacampus.fr', '$2y$10$fictivehashadmin', '0600000000', 'admin', 'Administrateur du site', 1),
            ('Thomas', 'Dubreuil', 'thomas.d@etu.u-picardie.fr', '$2y$10$fictivehash123', '0612345678', 'user', 'Étudiant en Droit à la Citadelle.', 1),
            ('Sophie', 'Martin', 'sophie.m@etu.u-picardie.fr', '$2y$10$fictivehash456', '0789101112', 'user', 'J''adore le covoit !', 1),
            ('Lucas', 'Petit', 'lucas.p@esiee.fr', '$2y$10$fictivehash789', '0655443322', 'user', 'Futur ingénieur ESIEE.', 1),
            ('Emma', 'Leroy', 'emma.l@gmail.com', '$2y$10$fictivehash321', '0699887766', 'user', 'J''aime la musique pop.', 0);

            INSERT INTO VEHICLES (make, model, color, license_plate, seats_total, owner_id) VALUES 
            ('Peugeot', '208', 'Gris', 'AB-123-CD', 4, 2),
            ('Renault', 'Clio 5', 'Bleu', 'XY-987-ZW', 4, 4);

            INSERT INTO TRIPS (start_address, start_lat, start_long, end_address, end_lat, end_long, start_time, end_time, distance_km, description, price, status, driver_id, vehicle_id, seats_available) VALUES 
            ('La Citadelle, Amiens', 49.904406, 2.299499, 'Porte Maillot, Paris', 48.878768, 2.282635, '2026-06-15 14:00:00', '2026-06-15 16:30:00', 145.0, 'Départ après les cours.', 12.50, 'planned', 2, 1, 3),
            ('Gare Lille Flandres', 50.635900, 3.069800, 'ESIEE, Amiens', 49.900248, 2.291968, '2024-01-10 09:00:00', '2024-01-10 10:45:00', 110.0, 'Retour de weekend.', 9.00, 'completed', 4, 2, 2);

            INSERT INTO TRIP_STOPS (stop_address, stop_order, latitude, longitude, arrival_time, trip_id) VALUES 
            ('Gare de Longueau', 1, 49.868200, 2.353300, '2026-06-15 14:20:00', 1);

            INSERT INTO BOOKINGS (seats_booked, status, passenger_id, trip_id) VALUES 
            (1, 'pending', 3, 1),
            (1, 'confirmed', 5, 2);

            INSERT INTO MESSAGES (content, from_user_id, to_user_id, trip_id) VALUES 
            ('Bonjour Thomas, as-tu de la place pour une grosse valise ?', 3, 2, 1),
            ('Salut Sophie, oui pas de soucis le coffre est vide !', 2, 3, 1);

            INSERT INTO RATINGS (rating, comment, trip_id, rated_id, rater_id) VALUES 
            (5, 'Super conducteur, très ponctuel et sympa !', 2, 4, 5);

            INSERT INTO NOTIFICATIONS (type, message, user_id) VALUES 
            ('booking_request', 'Sophie M. souhaite réserver 1 place pour votre trajet vers Paris.', 2);

            INSERT INTO REPORTS (reason, description, status, trip_id, reported_user_id, reporter_id) VALUES 
            ('Retard', 'Le conducteur avait 30min de retard au départ', 'open', 2, 4, 5);

            INSERT INTO LOGS_ADMIN (action, target_user_id, admin_id) VALUES 
            ('USER_VERIFICATION_VALIDATED', 2, 1);
        SQL);

        // Set all passwords to 'password' so users can log in
        DB::table('USERS')->update(['password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);

        Schema::enableForeignKeyConstraints();
    }
}
