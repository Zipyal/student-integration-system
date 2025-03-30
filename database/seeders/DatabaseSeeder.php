<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Event;
use App\Models\Message;
use App\Models\Material;
use App\Models\Registration;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Создаем администратора
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
            'role' => 'admin'
        ]);

        // 2. Создаем кураторов
        $curators = User::factory()
            ->count(3)
            ->create([
                'role' => 'curator'
            ]);

        // 3. Создаем студентов для каждого куратора
        $students = collect();
        $curators->each(function ($curator) use (&$students) {
            $students = $students->merge(
                User::factory()
                    ->count(5)
                    ->create([
                        'role' => 'student',
                        'curator_id' => $curator->id
                    ])
            );
        });

        // 4. Создаем мероприятия
        $events = Event::factory()
            ->count(10)
            ->create();

        // 5. Создаем регистрации на мероприятия
        $events->each(function ($event) use ($students) {
            $eventStudents = $students->random(rand(3, 7));
            $eventStudents->each(function ($student) use ($event) {
                Registration::create([
                    'user_id' => $student->id,
                    'event_id' => $event->id,
                    'confirmed' => rand(0, 1)
                ]);
            });
        });

        // 6. Создаем сообщения между пользователями
        Message::factory()
            ->count(30)
            ->create([
                'sender_id' => function() use ($students, $curators, $admin) {
                    return collect([$students, $curators, [$admin]])->flatten()->random()->id;
                },
                'receiver_id' => function() use ($students, $curators, $admin) {
                    return collect([$students, $curators, [$admin]])->flatten()->random()->id;
                }
            ]);

        // 7. Создаем адаптационные материалы
        Material::factory()
            ->count(15)
            ->create();
    }
}