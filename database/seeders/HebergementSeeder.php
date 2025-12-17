<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hebergement;
use Illuminate\Support\Facades\DB; // Optionnel, mais préférable pour tronquer

class HebergementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vider la table avant d'insérer les nouvelles données de démo
        DB::table('hebergements')->truncate();

        // Vos données "en dur" converties en PHP
        $hebergements = [
            [
                'title' => 'Hôtel 2 Février',
                'location' => 'Lomé',
                'rating' => 4.5, 
                'price' => '45 000 FCFA/nuit',
                'description' => 'Hôtel moderne au cœur de Lomé, proche des attractions principales et de la plage.',
                'features' => json_encode(["WiFi gratuit", "Piscine", "Restaurant", "Centre d'affaires"]),
                'image' => 'H2.jpeg', 
                'type' => 'Hôtels',
            ],
            [
                'title' => 'Lodge de la Cascade',
                'location' => 'Kpalimé',
                'rating' => 4.8,
                'price' => '35 000 FCFA/nuit',
                'description' => 'Lodge écologique offrant une expérience immersive dans la nature de Kpalimé.',
                'features' => json_encode(["Vue sur cascade", "Randonnées guidées", "Restaurant bio", "Petit-déjeuner inclus"]),
                'image' => 'lodge.jpeg',
                'type' => 'Lodges Écologiques',
            ],
            [
                'title' => 'Auberge du Voyageur',
                'location' => 'Kara',
                'rating' => 4.2,
                'price' => '15 000 FCFA/nuit',
                'description' => 'Auberge chaleureuse pour découvrir la culture Kabyè et les traditions locales.',
                'features' => json_encode(["Petit-déjeuner inclus", "WiFi gratuit", "Terrasse commune", "Parking"]),
                'image' => 'auberge.jpeg',
                'type' => 'Auberges',
            ],
            [
                'title' => 'Resort de luxe face à l\'océan',
                'location' => 'Aného',
                'rating' => 4.7,
                'price' => '75 000 FCFA/nuit',
                'description' => 'Resort de luxe face à l\'océan, parfait pour une escapade romantique.',
                'features' => json_encode(["Accès plage privée", "Spa", "Sports nautiques", "Bar"]),
                'image' => 'ane.jpeg',
                'type' => 'Stations balnéaires',
            ],
            [
                'title' => 'Hôtel des Plateaux',
                'location' => 'Sokodé',
                'rating' => 4.3,
                'price' => '30 000 FCFA/nuit',
                'description' => 'Hôtel confortable au centre de Sokodé, idéal pour les voyages d\'affaires.',
                'features' => json_encode(["Centre d'affaires", "Restaurant", "Parking", "WiFi gratuit"]),
                'image' => 'hotel.jpeg',
                'type' => 'Hôtels',
            ],
            [
                'title' => 'Pavillon Savane',
                'location' => 'Dapaong',
                'rating' => 4.6,
                'price' => '40 000 FCFA/nuit',
                'description' => 'Lodge authentique pour explorer la savane du nord et observer la faune.',
                'features' => json_encode(["Safari", "Faune d'observation", "Terrasse commune", "Randonnées guidées"]),
                'image' => 'lodge1.jpeg',
                'type' => 'Lodges Écologiques',
            ],
        ];

        // Insérer toutes les données
        foreach ($hebergements as $hebergement) {
            Hebergement::create($hebergement);
        }
    }
}