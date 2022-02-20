<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>


## Test Technique Appsolute

Ajouter des variables d'environnement telles que DB credentials(nécessaire):
```bash
cp env.example .env
```

Lancer les migrations:
```bash
php artisan migrate
```

Insérer un premier jeu de données:
```bash
php artisan db:seed
```

Lancer l'application:
```bash
php artisan serve
```

Tester l'application:
```bash
php artisan test
```

- Documentation de l'api: http://localhost:8000/api/docs
- Collection PostMan: https://www.getpostman.com/collections/f327ec1b2bbee8d5a865

