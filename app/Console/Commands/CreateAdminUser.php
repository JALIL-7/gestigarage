<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdminUser extends Command
{
    /**
     * Le nom et la signature de la commande.
     * Exemple: php artisan admin:create jean@exemple.com secret123
     */
    protected $signature = 'admin:create {email} {password} {--name=Admin}';

    /**
     * La description de la commande.
     */
    protected $description = 'Créer un nouvel utilisateur administrateur de façon sécurisée';

    /**
     * Exécuter la commande.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');
        $name = $this->option('name');

        // Validation basique
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error("L'adresse email n'est pas valide.");
            return 1;
        }

        // Vérifier si l'utilisateur existe déjà
        if (User::where('email', $email)->exists()) {
            $this->error("Un utilisateur avec cet email existe déjà !");
            return 1;
        }

        // Créer l'utilisateur dans la bonne table avec le mot de passe haché !
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info("Victoire 🎉 ! L'administrateur {$user->email} a été créé avec succès.");
        return 0;
    }
}
