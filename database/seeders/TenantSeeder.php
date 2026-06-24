<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Total: 38 tenants
     *   Floor 2 →  5 tenants
     *   Floor 3 → 11 tenants
     *   Floor 4 → 12 tenants
     *   Floor 5 → 10 tenants
     */
    public function run(): void
    {
        // Fetch all active rooms grouped by floor
        $roomsByFloor = \App\Models\Room::where('is_active', true)
            ->get()
            ->groupBy('floor');

        // Prepare room assignment track
        $roomAssignments = [];
        foreach ($roomsByFloor as $floor => $rooms) {
            $roomAssignments[$floor] = [];
            foreach ($rooms as $room) {
                $roomAssignments[$floor][] = [
                    'room_number' => $room->room_number,
                    'floor'       => $room->floor,
                    'stay_type'   => $room->stay_type,
                    'capacity'    => $room->capacity,
                    'occupancy'   => 0
                ];
            }
        }

        $tenants = [

            // ----------------------------------------------------------------
            // FLOOR 2 — 5 tenants
            // ----------------------------------------------------------------
            [
                'first_name'     => 'Maria',
                'last_name'      => 'Santos',
                'email'          => 'maria.santos@example.com',
                'contact_number' => '09171234501',
                'floor'          => 2,
                'move_in_date'   => '2024-01-15',
                'status'         => 'pending',
            ],
            [
                'first_name'     => 'Sofia',
                'last_name'      => 'Reyes',
                'email'          => 'sofia.reyes@example.com',
                'contact_number' => '09171234502',
                'floor'          => 2,
                'move_in_date'   => '2024-02-01',
                'status'         => 'pending',
            ],
            [
                'first_name'     => 'Ana',
                'last_name'      => 'Cruz',
                'email'          => 'ana.cruz@example.com',
                'contact_number' => '09171234503',
                'floor'          => 2,
                'move_in_date'   => '2024-02-10',
                'status'         => 'pending',
            ],
            [
                'first_name'     => 'Elena',
                'last_name'      => 'Bautista',
                'email'          => 'elena.bautista@example.com',
                'contact_number' => '09171234504',
                'floor'          => 2,
                'move_in_date'   => '2024-03-01',
                'status'         => 'pending',
            ],
            [
                'first_name'     => 'Liza',
                'last_name'      => 'Garcia',
                'email'          => 'liza.garcia@example.com',
                'contact_number' => '09171234505',
                'floor'          => 2,
                'move_in_date'   => '2024-03-15',
                'status'         => 'pending',
            ],

            // ----------------------------------------------------------------
            // FLOOR 3 — 11 tenants
            // ----------------------------------------------------------------
            [
                'first_name'     => 'Grace',
                'last_name'      => 'Dela Cruz',
                'email'          => 'grace.delacruz@example.com',
                'contact_number' => '09181234501',
                'floor'          => 3,
                'move_in_date'   => '2024-01-10',
                'status'         => 'pending',
            ],
            [
                'first_name'     => 'Jenny',
                'last_name'      => 'Villanueva',
                'email'          => 'jenny.villanueva@example.com',
                'contact_number' => '09181234502',
                'floor'          => 3,
                'move_in_date'   => '2024-01-20',
                'status'         => 'pending',
            ],
            [
                'first_name'     => 'Chloe',
                'last_name'      => 'Mendoza',
                'email'          => 'chloe.mendoza@example.com',
                'contact_number' => '09181234503',
                'floor'          => 3,
                'move_in_date'   => '2024-02-05',
                'status'         => 'pending',
            ],
            [
                'first_name'     => 'Claire',
                'last_name'      => 'Aquino',
                'email'          => 'claire.aquino@example.com',
                'contact_number' => '09181234504',
                'floor'          => 3,
                'move_in_date'   => '2024-02-15',
                'status'         => 'pending',
            ],
            [
                'first_name'     => 'Mia',
                'last_name'      => 'Torres',
                'email'          => 'mia.torres@example.com',
                'contact_number' => '09181234505',
                'floor'          => 3,
                'move_in_date'   => '2024-02-20',
                'status'         => 'pending',
            ],
            [
                'first_name'     => 'Patricia',
                'last_name'      => 'Ramos',
                'email'          => 'patricia.ramos@example.com',
                'contact_number' => '09181234506',
                'floor'          => 3,
                'move_in_date'   => '2024-03-01',
                'status'         => 'pending',
            ],
            [
                'first_name'     => 'Camila',
                'last_name'      => 'Soriano',
                'email'          => 'camila.soriano@example.com',
                'contact_number' => '09181234507',
                'floor'          => 3,
                'move_in_date'   => '2024-03-10',
                'status'         => 'pending',
            ],
            [
                'first_name'     => 'Diana',
                'last_name'      => 'Castillo',
                'email'          => 'diana.castillo@example.com',
                'contact_number' => '09181234508',
                'floor'          => 3,
                'move_in_date'   => '2024-03-20',
                'status'         => 'pending',
            ],
            [
                'first_name'     => 'Isabella',
                'last_name'      => 'Navarro',
                'email'          => 'isabella.navarro@example.com',
                'contact_number' => '09181234509',
                'floor'          => 3,
                'move_in_date'   => '2024-04-01',
                'status'         => 'pending',
            ],
            [
                'first_name'     => 'Sophia',
                'last_name'      => 'Flores',
                'email'          => 'sophia.flores@example.com',
                'contact_number' => '09181234510',
                'floor'          => 3,
                'move_in_date'   => '2024-04-10',
                'status'         => 'pending',
            ],
            [
                'first_name'     => 'Gabriela',
                'last_name'      => 'Pascual',
                'email'          => 'gabriela.pascual@example.com',
                'contact_number' => '09181234511',
                'floor'          => 3,
                'move_in_date'   => '2024-04-15',
                'status'         => 'pending',
            ],

            // ----------------------------------------------------------------
            // FLOOR 4 — 12 tenants
            // ----------------------------------------------------------------
            [
                'first_name'     => 'Isabel',
                'last_name'      => 'Gonzales',
                'email'          => 'isabel.gonzales@example.com',
                'contact_number' => '09191234501',
                'floor'          => 4,
                'move_in_date'   => '2024-01-05',
                'status'         => 'pending',
            ],
            [
                'first_name'     => 'Olivia',
                'last_name'      => 'Hernandez',
                'email'          => 'olivia.hernandez@example.com',
                'contact_number' => '09191234502',
                'floor'          => 4,
                'move_in_date'   => '2024-01-15',
                'status'         => 'pending',
            ],
            [
                'first_name'     => 'Nicole',
                'last_name'      => 'Magno',
                'email'          => 'nicole.magno@example.com',
                'contact_number' => '09191234503',
                'floor'          => 4,
                'move_in_date'   => '2024-01-25',
                'status'         => 'pending',
            ],
            [
                'first_name'     => 'Emily',
                'last_name'      => 'Salazar',
                'email'          => 'emily.salazar@example.com',
                'contact_number' => '09191234504',
                'floor'          => 4,
                'move_in_date'   => '2024-02-01',
                'status'         => 'pending',
            ],
            [
                'first_name'     => 'Camille',
                'last_name'      => 'Dizon',
                'email'          => 'camille.dizon@example.com',
                'contact_number' => '09191234505',
                'floor'          => 4,
                'move_in_date'   => '2024-02-10',
                'status'         => 'pending',
            ],
            [
                'first_name'     => 'Jessica',
                'last_name'      => 'Reyes',
                'email'          => 'jessica.reyes@example.com',
                'contact_number' => '09191234506',
                'floor'          => 4,
                'move_in_date'   => '2024-02-20',
                'status'         => 'pending',
            ],
            [
                'first_name'     => 'Angelica',
                'last_name'      => 'Luna',
                'email'          => 'angelica.luna@example.com',
                'contact_number' => '09191234507',
                'floor'          => 4,
                'move_in_date'   => '2024-03-01',
                'status'         => 'pending',
            ],
            [
                'first_name'     => 'Samantha',
                'last_name'      => 'Buenaventura',
                'email'          => 'samantha.buenaventura@example.com',
                'contact_number' => '09191234508',
                'floor'          => 4,
                'move_in_date'   => '2024-03-10',
                'status'         => 'pending',
            ],
            [
                'first_name'     => 'Trisha',
                'last_name'      => 'Enriquez',
                'email'          => 'trisha.enriquez@example.com',
                'contact_number' => '09191234509',
                'floor'          => 4,
                'move_in_date'   => '2024-03-20',
                'status'         => 'pending',
            ],
            [
                'first_name'     => 'Alyssa',
                'last_name'      => 'Santiago',
                'email'          => 'alyssa.santiago@example.com',
                'contact_number' => '09191234510',
                'floor'          => 4,
                'move_in_date'   => '2024-04-01',
                'status'         => 'pending',
            ],
            [
                'first_name'     => 'Kristine',
                'last_name'      => 'Domingo',
                'email'          => 'kristine.domingo@example.com',
                'contact_number' => '09191234511',
                'floor'          => 4,
                'move_in_date'   => '2024-04-05',
                'status'         => 'pending',
            ],
            [
                'first_name'     => 'Rachel',
                'last_name'      => 'Aguilar',
                'email'          => 'rachel.aguilar@example.com',
                'contact_number' => '09191234512',
                'floor'          => 4,
                'move_in_date'   => '2024-04-15',
                'status'         => 'pending',
            ],

            // ----------------------------------------------------------------
            // FLOOR 5 — 10 tenants
            // ----------------------------------------------------------------
            [
                'first_name'     => 'Vanessa',
                'last_name'      => 'Manaloto',
                'email'          => 'vanessa.manaloto@example.com',
                'contact_number' => '09201234501',
                'floor'          => 5,
                'move_in_date'   => '2024-01-08',
                'status'         => 'pending',
            ],
            [
                'first_name'     => 'Hazel',
                'last_name'      => 'Ocampo',
                'email'          => 'hazel.ocampo@example.com',
                'contact_number' => '09201234502',
                'floor'          => 5,
                'move_in_date'   => '2024-01-18',
                'status'         => 'pending',
            ],
            [
                'first_name'     => 'Maricel',
                'last_name'      => 'Padilla',
                'email'          => 'maricel.padilla@example.com',
                'contact_number' => '09201234503',
                'floor'          => 5,
                'move_in_date'   => '2024-02-03',
                'status'         => 'pending',
            ],
            [
                'first_name'     => 'Angela',
                'last_name'      => 'Tolentino',
                'email'          => 'angela.tolentino@example.com',
                'contact_number' => '09201234504',
                'floor'          => 5,
                'move_in_date'   => '2024-02-12',
                'status'         => 'pending',
            ],
            [
                'first_name'     => 'Roxanne',
                'last_name'      => 'Medina',
                'email'          => 'roxanne.medina@example.com',
                'contact_number' => '09201234505',
                'floor'          => 5,
                'move_in_date'   => '2024-02-22',
                'status'         => 'pending',
            ],
            [
                'first_name'     => 'Evelyn',
                'last_name'      => 'Valdez',
                'email'          => 'evelyn.valdez@example.com',
                'contact_number' => '09201234506',
                'floor'          => 5,
                'move_in_date'   => '2024-03-05',
                'status'         => 'pending',
            ],
            [
                'first_name'     => 'Sheila',
                'last_name'      => 'Mercado',
                'email'          => 'sheila.mercado@example.com',
                'contact_number' => '09201234507',
                'floor'          => 5,
                'move_in_date'   => '2024-03-15',
                'status'         => 'pending',
            ],
            [
                'first_name'     => 'Clarissa',
                'last_name'      => 'Macaraeg',
                'email'          => 'clarissa.macaraeg@example.com',
                'contact_number' => '09201234508',
                'floor'          => 5,
                'move_in_date'   => '2024-03-25',
                'status'         => 'pending',
            ],
            [
                'first_name'     => 'Elaine',
                'last_name'      => 'Espiritu',
                'email'          => 'elaine.espiritu@example.com',
                'contact_number' => '09201234509',
                'floor'          => 5,
                'move_in_date'   => '2024-04-02',
                'status'         => 'pending',
            ],
            [
                'first_name'     => 'Joy',
                'last_name'      => 'Ybañez',
                'email'          => 'joy.ybanez@example.com',
                'contact_number' => '09201234510',
                'floor'          => 5,
                'move_in_date'   => '2024-04-12',
                'status'         => 'pending',
            ],
        ];

        foreach ($tenants as $data) {
            $tempPassword = Tenant::generateTempPassword();
            $floor = $data['floor'];
            $roomNumber = null;
            $stayType = null;

            if (isset($roomAssignments[$floor])) {
                foreach ($roomAssignments[$floor] as &$r) {
                    if ($r['occupancy'] < $r['capacity']) {
                        $r['occupancy']++;
                        $roomNumber = $r['room_number'];
                        $stayType = $r['stay_type'];
                        break;
                    }
                }
            }

            // Fallback just in case
            if (!$roomNumber) {
                $roomNumber = $floor . '01';
                $stayType = 'Solo Room';
            }

            Tenant::create([
                'account_id'       => Tenant::generateAccountId(),
                'password_hash'    => \Illuminate\Support\Facades\Hash::make($tempPassword),
                'is_temp_password' => true,
                'first_name'       => $data['first_name'],
                'last_name'        => $data['last_name'],
                'email'            => $data['email'],
                'contact_number'   => $data['contact_number'],
                'profile_photo'    => null,
                'room_number'      => $roomNumber,
                'floor'            => $floor,
                'stay_type'        => $stayType,
                'move_in_date'     => $data['move_in_date'],
                'move_out_date'    => null,
                'status'           => $data['status'],
                'is_active'        => true,
                'last_login_at'    => null,
                'notes'            => null,
            ]);
        }
    }
}
