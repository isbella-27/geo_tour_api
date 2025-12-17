<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Destination::truncate();

        $destinations = [
            // --- 1. Lomé (Maritime) ---
            [
                'title' => 'Lomé',
                'region' => 'Maritime',
                'description' => 'Capitale vibrante du Togo, Lomé séduit par ses marchés colorés, son architecture coloniale et ses magnifiques plages de sable fin. Le Grand Marché et le marché des féticheurs offrent une immersion authentique dans la culture togolaise.',
                'bestPeriod' => 'Novembre à Mars',
                'image' => 'destinations/lome.jpeg',
                'pointsOfInterest' => json_encode([
                    "Plage de Lomé",
                    "Grand Marché",
                    "Marché des féticheurs",
                    "Cathédrale du Sacré-Cœur"
                ]),
            ],

            // --- 2. Kpalimé (Plateaux) ---
            [
                'title' => 'Kpalimé',
                'region' => 'Plateaux',
                'description' => 'Nichée dans les montagnes, Kpalimé est le paradis des amoureux de la nature. Ses cascades spectaculaires, ses forêts tropicales et ses plantations de café en font une destination incontournable pour l\'écotourisme.',
                'bestPeriod' => 'Octobre à Avril',
                'image' => 'destinations/cascade.jpg',
                'pointsOfInterest' => json_encode([
                    "Cascade de Womé",
                    "Mont Agou",
                    "Forêt de Missahöhé",
                    "Plantations de café"
                ]),
            ],

            // --- 3. Kara (Kara) ---
            [
                'title' => 'Kara',
                // Attention: Votre code React utilise "Kara", mais pour le tag, j'ai vu "savanes". 
                // Je vais utiliser la région 'Kara' car c'est une capitale régionale.
                'region' => 'Kara',
                'description' => 'Terre des traditions Kabyè, Kara offre une plongée authentique dans la culture togolaise. Ses villages traditionnels, ses marchés d\'artisanat et ses paysages de savane en font une destination culturelle unique.',
                'bestPeriod' => 'Novembre à Février',
                'image' => 'destinations/kara.jpg',
                'pointsOfInterest' => json_encode([
                    "Villages Kabyè",
                    "Marché de Kara",
                    "Artisanat local",
                    "Paysages de savane"
                ]),
            ],

            // --- 4. Sokodé (Centrale) ---
            [
                'title' => 'Sokodé',
                'region' => 'Centrale',
                'description' => 'Carrefour commercial historique, Sokodé est réputée pour ses traditions Tem et ses festivals colorés. La ville offre un aperçu fascinant de la diversité culturelle du Togo central.',
                'bestPeriod' => 'Décembre à Mars',
                'image' => 'destinations/tem.jpg',
                'pointsOfInterest' => json_encode([
                    "Marché central",
                    "Festivals Tem",
                    "Architecture traditionnelle",
                    "Artisanat textile"
                ]),
            ],

            // --- 5. Aného (Maritime) ---
            [
                'title' => 'Aného',
                'region' => 'Maritime',
                'description' => 'Ancienne capitale coloniale, Aného charme par son patrimoine historique et ses plages préservées. Ses maisons coloniales et son ambiance paisible en font une destination parfaite pour la détente.',
                'bestPeriod' => 'Novembre à Avril',
                'image' => 'destinations/aneho.jpg',
                'pointsOfInterest' => json_encode([
                    "Architecture coloniale",
                    "Plages tranquilles",
                    "Musée d'Aného",
                    "Lagune côtière"
                ]),
            ],

            // --- 6. Dapaong (Savanes) ---
            [
                'title' => 'Dapaong',
                'region' => 'Savanes',
                'description' => 'Porte d\'entrée du nord du Togo, Dapaong offre des paysages de savane à perte de vue et une culture riche. C\'est le point de départ idéal pour explorer les parcs nationaux et rencontrer les communautés locales.',
                'bestPeriod' => 'Novembre à Mars',
                'image' => 'destinations/keran.jpg',
                'pointsOfInterest' => json_encode([
                    "Parc National Oti-Kéran",
                    "Villages traditionnels",
                    "Savane africaine",
                    "Artisanat du Nord"
                ]),
            ],
        ];

        // Insertion des données dans la base
        foreach ($destinations as $destinationData) {
            Destination::create($destinationData);
        }
    }
}
